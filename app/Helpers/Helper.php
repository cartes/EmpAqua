<?php

namespace App\Helpers;

class Helper
{
    public static function uploadFile($key, $path)
    {
        // Guarda el archivo y retorna la ruta completa
        $fullPath = request()->file($key)->store($path, 'public');
        
        // Retorna solo el nombre del archivo sin el directorio
        return basename($fullPath);
    }



    /**
     * Sanea HTML de usuario: conserva solo etiquetas de formato básicas
     * y elimina atributos, scripts y manejadores de eventos.
     */
    public static function cleanHtml($html)
    {
        if ($html === null || $html === '') {
            return '';
        }

        $allowed = ['p', 'br', 'b', 'strong', 'i', 'em', 'u', 'ul', 'ol', 'li', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'span', 'div', 'blockquote'];

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?><body>' . $html . '</body>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $clean = function (\DOMNode $node) use (&$clean, $allowed) {
            foreach (iterator_to_array($node->childNodes) as $child) {
                if ($child instanceof \DOMElement) {
                    $clean($child);
                    if (!in_array(strtolower($child->nodeName), $allowed, true)) {
                        if (in_array(strtolower($child->nodeName), ['script', 'style', 'iframe', 'object', 'embed'], true)) {
                            $node->removeChild($child);
                            continue;
                        }
                        while ($child->firstChild) {
                            $node->insertBefore($child->firstChild, $child);
                        }
                        $node->removeChild($child);
                        continue;
                    }
                    foreach (iterator_to_array($child->attributes) as $attr) {
                        $child->removeAttribute($attr->nodeName);
                    }
                }
            }
        };

        $body = $dom->getElementsByTagName('body')->item(0);
        if (!$body) {
            return e(strip_tags($html));
        }
        $clean($body);

        $out = '';
        foreach ($body->childNodes as $child) {
            $out .= $dom->saveHTML($child);
        }
        return $out;
    }
}
