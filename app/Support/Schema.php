<?php

namespace App\Support;

use App\Models\Offers;
use Carbon\Carbon;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\HtmlString;

/**
 * Generadores de datos estructurados (schema.org / JSON-LD).
 */
class Schema
{
    const SITE_NAME = 'EmpleosAqua';

    /** Renderiza un nodo JSON-LD listo para insertar en el <head>. */
    public static function script(?array $data): HtmlString
    {
        if (empty($data)) {
            return new HtmlString('');
        }

        $json = json_encode(
            ['@context' => 'https://schema.org'] + $data,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP
        );

        return new HtmlString('<script type="application/ld+json">' . $json . '</script>');
    }

    public static function organization(): array
    {
        return [
            '@type' => 'Organization',
            '@id' => url('/') . '#organization',
            'name' => self::SITE_NAME,
            'url' => url('/'),
            'logo' => asset('images/1x/logo-empleos-aqua.png'),
            'parentOrganization' => [
                '@type' => 'Organization',
                'name' => 'B2B Group Media SPA',
            ],
        ];
    }

    public static function website(): array
    {
        return [
            '@type' => 'WebSite',
            '@id' => url('/') . '#website',
            'name' => self::SITE_NAME,
            'url' => url('/'),
            'inLanguage' => 'es-CL',
            'publisher' => ['@id' => url('/') . '#organization'],
        ];
    }

    /** Página estática: $type es WebPage, AboutPage, ContactPage o FAQPage. */
    public static function webPage(string $type, string $name, string $url, ?string $description = null, array $extra = []): array
    {
        return array_filter([
            '@type' => $type,
            'name' => $name,
            'url' => $url,
            'description' => $description,
            'inLanguage' => 'es-CL',
            'isPartOf' => ['@id' => url('/') . '#website'],
            'breadcrumb' => self::breadcrumb([self::SITE_NAME => url('/'), $name => $url]),
        ] + $extra);
    }

    /** @param array<string,string> $items nombre => url */
    public static function breadcrumb(array $items): array
    {
        $list = [];
        $position = 1;

        foreach ($items as $name => $url) {
            $list[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $name,
                'item' => $url,
            ];
        }

        return ['@type' => 'BreadcrumbList', 'itemListElement' => $list];
    }

    /** ItemList con enlaces a las ofertas (listados y home). */
    public static function itemList($offers): ?array
    {
        $items = [];
        $position = 1;

        foreach ($offers as $offer) {
            if (empty($offer->slug)) {
                continue;
            }

            $items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'url' => route('offer.show', ['slug' => $offer->slug]),
                'name' => $offer->title,
            ];
        }

        return $items ? ['@type' => 'ItemList', 'itemListElement' => $items] : null;
    }

    /** Extrae pregunta/respuesta del acordeón (.card) de la vista de FAQ. */
    public static function faqFromHtml(string $html): ?array
    {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="utf-8" ?><body>' . $html . '</body>');
        libxml_clear_errors();

        $xpath = new DOMXPath($doc);
        $entities = [];

        foreach ($xpath->query('//div[contains(@class,"card")]') as $card) {
            $question = $xpath->query('.//button', $card)->item(0);
            $answer = $xpath->query('.//div[contains(@class,"card-body")]', $card)->item(0);

            if (!$question || !$answer) {
                continue;
            }

            $entities[] = [
                '@type' => 'Question',
                'name' => self::clean($question->textContent),
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => self::clean($answer->textContent),
                ],
            ];
        }

        return $entities ? ['@type' => 'FAQPage', 'mainEntity' => $entities] : null;
    }

    /**
     * JobPosting para una ficha de oferta. Devuelve null si la oferta no
     * debe indexarse como empleo (despublicada o vencida).
     */
    public static function jobPosting(?Offers $offer): ?array
    {
        if (!$offer || !$offer->getRawOriginal('published') || empty($offer->slug)) {
            return null;
        }

        $expires = $offer->getRawOriginal('expirated_at');
        if (!$expires || Carbon::parse($expires)->isPast()) {
            return null;
        }

        $confidential = (bool) $offer->confidential;
        $meta = $offer->businessMeta;

        $organization = ['@type' => 'Organization'];
        if ($confidential || !$meta) {
            $organization['name'] = 'Prestigiosa Empresa';
        } else {
            $organization['name'] = $meta->fantasy_name ?: $meta->business_name;
            $logo = trim($meta->pathAttachment());
            if ($logo !== '') {
                $organization['logo'] = $logo;
            }
        }

        $description = $offer->description;
        if ($offer->requirements) {
            $requirements = $offer->requirements;
            if ($requirements === strip_tags($requirements)) {
                $requirements = nl2br(e(trim($requirements)));
            }
            $description .= '<h3>Requisitos</h3>' . $requirements;
        }
        if ($offer->Benefits->isNotEmpty()) {
            $description .= '<h3>Beneficios</h3><ul><li>'
                . $offer->Benefits->pluck('benefit')->map(fn ($b) => e($b))->implode('</li><li>')
                . '</li></ul>';
        }

        $data = [
            '@type' => 'JobPosting',
            'title' => $offer->title,
            'description' => $description,
            'identifier' => [
                '@type' => 'PropertyValue',
                'name' => self::SITE_NAME,
                'value' => (string) $offer->id,
            ],
            'datePosted' => Carbon::parse($offer->created_at)->toDateString(),
            'validThrough' => Carbon::parse($expires)->toIso8601String(),
            'employmentType' => self::employmentType($offer->getRawOriginal('position')),
            'hiringOrganization' => $organization,
            'jobLocation' => [
                '@type' => 'Place',
                'address' => array_filter([
                    '@type' => 'PostalAddress',
                    'addressLocality' => $offer->comune ?: $offer->city,
                    'addressRegion' => $offer->state,
                    'addressCountry' => 'CL',
                ]),
            ],
            'baseSalary' => self::baseSalary($offer),
            'industry' => optional($offer->category)->title,
            'totalJobOpenings' => $offer->vacancy ?: null,
            'directApply' => true,
            'url' => route('offer.show', ['slug' => $offer->slug]),
        ];

        return array_filter($data, fn ($v) => $v !== null && $v !== '');
    }

    private static function employmentType($position): ?string
    {
        return match ((string) $position) {
            '1' => 'FULL_TIME',
            '2' => 'PART_TIME',
            '3' => 'OTHER',
            default => null,
        };
    }

    /** Solo se emite cuando hay monto real (no "A convenir"). */
    private static function baseSalary(Offers $offer): ?array
    {
        $raw = (string) $offer->getRawOriginal('salary');
        $mode = (string) $offer->getRawOriginal('salary_array');

        if ($mode === '0' || $raw === '') {
            return null;
        }

        if ($mode === '2') {
            [$min, $max] = array_pad(array_map('intval', explode(' - ', $raw)), 2, null);
            $max = $max ?: $min;
        } else {
            $min = $max = (int) $raw;
        }

        if (!$min || $min <= 10000) {
            return null;
        }

        return [
            '@type' => 'MonetaryAmount',
            'currency' => 'CLP',
            'value' => $min === $max
                ? ['@type' => 'QuantitativeValue', 'value' => $min, 'unitText' => 'MONTH']
                : ['@type' => 'QuantitativeValue', 'minValue' => $min, 'maxValue' => $max, 'unitText' => 'MONTH'],
        ];
    }

    private static function clean(string $text): string
    {
        return trim(preg_replace('/\s+/u', ' ', $text));
    }
}
