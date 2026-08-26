<?php

namespace App\Rules;

use App\Support\UrlSanitizer;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Rule: SafeRedirectDestination
 *
 * Memvalidasi bahwa URL tujuan redirect hanya ke:
 * - Path relatif dalam situs sendiri (/tentang, /berita/xxx)
 * - URL ke domain aplikasi sendiri (APP_URL)
 *
 * Menolak redirect ke domain luar seperti link judol, situs iklan, dll.
 * Mencegah "Open Redirect Vulnerability".
 *
 * Penggunaan:
 *   'destination_url' => ['required', 'string', 'max:500', new SafeRedirectDestination()]
 */
class SafeRedirectDestination implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! UrlSanitizer::isValidRedirectDestination($value)) {
            $fail('URL tujuan redirect harus berupa path relatif (dimulai dengan /) atau URL ke domain situs sendiri. Redirect ke domain luar tidak diizinkan.');
        }
    }
}
