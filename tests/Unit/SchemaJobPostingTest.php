<?php

namespace Tests\Unit;

use App\Models\BusinessMeta;
use App\Models\Offers;
use App\Support\Schema;
use Illuminate\Support\Collection;
use Tests\TestCase;

class SchemaJobPostingTest extends TestCase
{
    private function makeOffer(array $offerAttrs = [], array $metaAttrs = []): Offers
    {
        $offer = new Offers();
        $offer->setRawAttributes(array_merge([
            'id' => 101,
            'title' => 'Jefe de Planta',
            'slug' => 'jefe-de-planta',
            'description' => '<p>Descripción del cargo</p>',
            'published' => 1,
            'expirated_at' => now()->addDays(10)->toDateTimeString(),
            'created_at' => now()->toDateTimeString(),
            'position' => 1,
            'status' => 0,
            'salary' => '0',
            'salary_array' => '0',
            'comune' => '',
            'city' => '',
            'state' => '',
        ], $offerAttrs), true);

        $meta = new BusinessMeta();
        $meta->setRawAttributes(array_merge([
            'business_name' => 'Acuícola Sur SpA',
            'fantasy_name' => 'Acuícola Sur',
            'address' => 'Av. Diego Portales 1234',
            'comune' => '',
            'city' => '',
            'state' => '',
            'path' => '',
        ], $metaAttrs));

        $offer->setRelation('businessMeta', $meta);
        $offer->setRelation('Benefits', new Collection());

        return $offer;
    }

    public function test_uses_business_meta_comune_without_exposing_street_address(): void
    {
        $offer = $this->makeOffer([], [
            'comune' => 'Puerto Montt',
        ]);

        $schema = Schema::jobPosting($offer);
        $address = $schema['jobLocation']['address'];

        $this->assertSame([
            '@type' => 'PostalAddress',
            'addressLocality' => 'Puerto Montt',
            'addressCountry' => 'CL',
        ], $address);
        $this->assertArrayNotHasKey('streetAddress', $address);
    }

    public function test_offer_comune_takes_precedence_over_business_meta_comune(): void
    {
        $offer = $this->makeOffer([
            'comune' => 'Castro',
            'state' => 'Los Lagos',
        ], [
            'comune' => 'Puerto Montt',
            'state' => 'Los Lagos',
        ]);

        $schema = Schema::jobPosting($offer);

        $this->assertSame([
            '@type' => 'PostalAddress',
            'addressLocality' => 'Castro',
            'addressRegion' => 'Los Lagos',
            'addressCountry' => 'CL',
        ], $schema['jobLocation']['address']);
    }

    public function test_only_country_is_emitted_when_no_locality_or_region_is_provided(): void
    {
        $offer = $this->makeOffer();

        $schema = Schema::jobPosting($offer);

        $this->assertSame([
            '@type' => 'PostalAddress',
            'addressCountry' => 'CL',
        ], $schema['jobLocation']['address']);
    }
}
