<?php

namespace App\Rules;

use App\Support\UrlSanitizer;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Rule: SafeButtonUrl
 *
 * Memvalidasi URL yang digunakan untuk tombol/link di Hero Slide, dll.
 *
 * Mengizinkan:
 * - Path relatif (/tentang, /berita/xxx)
 * - URL https:// atau http://
 * - mailto: dan tel:
 *
 * Menolak:
 * - javascript:, data:, vbscript: (XSS)
 * - URL tanpa scheme yang valid
 *
 * Penggunaan:
 *   'button_url' => ['nullable', 'string', 'max:255', new SafeButtonUrl()]
 */
class SafeButtonUrl implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            return; // nullable — nilai kosong diizinkan
        }

        if (! UrlSanitizer::isValidButtonUrl($value)) {
            $fail('Format URL tidak valid atau mengandung scheme yang tidak diizinkan (javascript:, data:, dll).');
        }
    }
}
