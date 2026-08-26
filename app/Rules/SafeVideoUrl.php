<?php

namespace App\Rules;

use App\Support\UrlSanitizer;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Rule: SafeVideoUrl
 *
 * Memvalidasi bahwa URL video hanya berasal dari platform resmi:
 * YouTube atau Vimeo.
 *
 * Menolak URL dari platform lain, termasuk domain judol, situs
 * iklan berbahaya, atau platform tidak terverifikasi.
 *
 * Penggunaan:
 *   'url' => ['required', 'string', 'max:500', new SafeVideoUrl()]
 */
class SafeVideoUrl implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! UrlSanitizer::isValidVideoUrl($value)) {
            $fail('URL video harus berasal dari YouTube atau Vimeo. URL dari platform lain tidak diizinkan.');
        }
    }
}
