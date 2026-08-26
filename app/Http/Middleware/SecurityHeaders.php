<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * SecurityHeaders Middleware
 *
 * Menambahkan HTTP security headers pada setiap response untuk:
 * - Mencegah XSS via Content-Security-Policy (CSP)
 * - Mencegah clickjacking via X-Frame-Options
 * - Mencegah MIME sniffing via X-Content-Type-Options
 * - Membatasi referrer info via Referrer-Policy
 * - Membatasi browser features via Permissions-Policy
 * - Memaksa HTTPS via HSTS (production only)
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Cegah MIME-type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Cegah clickjacking – frame hanya dari domain sendiri
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Batasi informasi referrer
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Nonaktifkan fitur browser yang tidak dibutuhkan
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=(), usb=()');

        // Hapus header yang mengekspos informasi server
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        // Content-Security-Policy (CSP) — lapisan pertahanan utama
        // Menentukan sumber konten yang diperbolehkan di browser
        $csp = $this->buildCSP($request);
        $response->headers->set('Content-Security-Policy', $csp);

        // HSTS: Paksa HTTPS selama 1 tahun (hanya di production)
        if (app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        return $response;
    }

    /**
     * Bangun string Content-Security-Policy.
     *
     * Kebijakan ini memblokir pemuatan resource dari domain lain yang tidak diizinkan,
     * termasuk link/script judol dan konten berbahaya dari luar.
     */
    private function buildCSP(Request $request): string
    {
        $self   = "'self'";
        $none   = "'none'";
        $unsafe = "'unsafe-inline'"; // Diperlukan untuk Tailwind inline style & editor

        // Daftar domain eksternal yang DIIZINKAN secara eksplisit
        $allowedFonts   = 'fonts.gstatic.com fonts.googleapis.com';
        $allowedStyles  = 'fonts.googleapis.com cdn.jsdelivr.net cdn.quilljs.com';
        $allowedImages  = 'i.ytimg.com *.ytimg.com data: blob:';
        $allowedFrames  = 'www.youtube.com www.youtube-nocookie.com player.vimeo.com';
        $allowedScripts = 'cdn.jsdelivr.net cdn.quilljs.com'; // Diizinkan untuk library rich text editor

        // Nonce untuk inline script (jika dibutuhkan)
        // Untuk sekarang gunakan unsafe-inline agar tidak break editor

        $directives = [
            // Hanya izinkan resource dari domain sendiri secara default
            "default-src {$self}",

            // Script: domain sendiri + CDN Quill/HTML editor + unsafe-inline + unsafe-eval
            "script-src {$self} {$unsafe} 'unsafe-eval' {$allowedScripts}",

            // Style: domain sendiri + Google Fonts + unsafe-inline (Tailwind)
            "style-src {$self} {$unsafe} {$allowedStyles}",

            // Font: domain sendiri + Google Fonts
            "font-src {$self} {$allowedFonts}",

            // Gambar: domain sendiri + YouTube thumbnail + data URI
            "img-src {$self} {$allowedImages}",

            // Frame: HANYA YouTube/Vimeo — blokir semua domain lain termasuk judol
            "frame-src {$allowedFrames}",

            // Child frame (sama dengan frame-src)
            "child-src {$allowedFrames} blob:",

            // Koneksi XHR/fetch: hanya domain sendiri
            "connect-src {$self}",

            // Media (audio/video): hanya domain sendiri
            "media-src {$self} blob:",

            // Object/embed/applet: DILARANG total
            "object-src {$none}",

            // Form action: hanya domain sendiri — cegah form submission ke luar
            "form-action {$self}",

            // Frame ancestor: domain sendiri saja (prevent embedding kita di judol)
            "frame-ancestors {$self}",

            // Manifest: domain sendiri
            "manifest-src {$self}",

            // Worker/ServiceWorker: domain sendiri
            "worker-src {$self} blob:",

            // Base URI: hanya domain sendiri (cegah base tag injection)
            "base-uri {$self}",

            // Upgrade HTTP ke HTTPS di production
            app()->environment('production') ? 'upgrade-insecure-requests' : '',
        ];

        // Hapus direktif kosong dan gabungkan
        return implode('; ', array_filter($directives));
    }
}
