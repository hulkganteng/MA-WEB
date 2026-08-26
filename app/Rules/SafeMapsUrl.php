<?php

namespace App\Rules;

use App\Support\UrlSanitizer;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Rule: SafeMapsUrl
 *
 * Memvalidasi bahwa URL Google Maps hanya dari domain Google yang resmi.
 *
 * Mengizinkan:
 * - google.com / www.google.com / maps.google.com
 * - goo.gl / maps.app.goo.gl
 *
 * Menolak URL ke domain selain Google Maps.
 *
 * Penggunaan:
 *   'maps_url' => ['nullable', 'url', 'max:1000', new SafeMapsUrl()]
 */
class SafeMapsUrl implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            return; // nullable — nilai kosong diizinkan
        }

        if (! UrlSanitizer::isValidMapsUrl($value)) {
            $fail('URL peta harus berasal dari Google Maps (google.com atau goo.gl).');
        }
    }
}
