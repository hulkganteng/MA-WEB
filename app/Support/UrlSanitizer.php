<?php

namespace App\Support;

/**
 * UrlSanitizer — Validasi dan sanitasi URL yang diterima dari input admin.
 *
 * Kelas ini memastikan URL yang disimpan ke database adalah URL yang aman:
 * - Tidak mengarah ke domain judol atau domain berbahaya lainnya
 * - Hanya menggunakan scheme yang diizinkan (https, /, mailto, tel)
 * - Link YouTube/Video hanya dari platform resmi (youtube.com, vimeo.com)
 *
 * Digunakan oleh:
 * - VideoController (url field)
 * - HeroSlideController (button_url, secondary_button_url)
 * - SettingController (maps_url)
 * - Redirect model (destination_url)
 */
class UrlSanitizer
{
    /**
     * Scheme yang diizinkan untuk URL umum (tombol, link, dll).
     */
    private const ALLOWED_SCHEMES = ['https', 'http', 'mailto', 'tel'];

    /**
     * Domain yang diizinkan untuk embed video.
     */
    private const ALLOWED_VIDEO_HOSTS = [
        'youtube.com',
        'www.youtube.com',
        'youtu.be',
        'm.youtube.com',
        'youtube-nocookie.com',
        'www.youtube-nocookie.com',
        'vimeo.com',
        'player.vimeo.com',
    ];

    /**
     * Domain yang diizinkan untuk embed peta.
     */
    private const ALLOWED_MAPS_HOSTS = [
        'google.com',
        'www.google.com',
        'maps.google.com',
        'goo.gl',
        'maps.app.goo.gl',
    ];

    /**
     * Validasi URL untuk tombol Hero Slide / link umum di dalam situs.
     *
     * Mengizinkan:
     * - Path relatif (/tentang, /berita/xxx)
     * - URL HTTPS ke domain sendiri
     * - URL HTTPS ke domain luar (untuk link-link yang sah seperti media sosial sekolah)
     *
     * Menolak:
     * - javascript: URI
     * - data: URI
     * - URL dengan scheme tidak dikenal
     * - URL tanpa host yang valid
     */
    public static function isValidButtonUrl(?string $url): bool
    {
        if (empty($url)) {
            return true; // nullable, boleh kosong
        }

        // Path relatif selalu aman
        if (str_starts_with($url, '/') && ! str_starts_with($url, '//')) {
            return true;
        }

        // Blokir eksplisit scheme berbahaya
        $lower = strtolower($url);
        if (str_starts_with($lower, 'javascript:') || str_starts_with($lower, 'data:') || str_starts_with($lower, 'vbscript:')) {
            return false;
        }

        $parsed = parse_url($url);
        if (! $parsed || ! isset($parsed['scheme'])) {
            return false;
        }

        return in_array(strtolower($parsed['scheme']), self::ALLOWED_SCHEMES, true);
    }

    /**
     * Validasi URL video — harus dari YouTube atau Vimeo.
     */
    public static function isValidVideoUrl(?string $url): bool
    {
        if (empty($url)) {
            return false;
        }

        $parsed = parse_url($url);
        if (! $parsed || ! isset($parsed['host'])) {
            return false;
        }

        $host = strtolower($parsed['host']);

        return in_array($host, self::ALLOWED_VIDEO_HOSTS, true);
    }

    /**
     * Validasi URL Google Maps.
     */
    public static function isValidMapsUrl(?string $url): bool
    {
        if (empty($url)) {
            return true; // nullable
        }

        $parsed = parse_url($url);
        if (! $parsed || ! isset($parsed['host'])) {
            return false;
        }

        $host = strtolower($parsed['host']);

        return in_array($host, self::ALLOWED_MAPS_HOSTS, true);
    }

    /**
     * Validasi URL untuk redirect destination.
     * Hanya izinkan path relatif atau URL ke domain aplikasi sendiri.
     */
    public static function isValidRedirectDestination(?string $url): bool
    {
        if (empty($url)) {
            return false;
        }

        // Path relatif
        if (str_starts_with($url, '/') && ! str_starts_with($url, '//')) {
            return true;
        }

        $appUrl = rtrim(config('app.url', ''), '/');

        if (empty($appUrl)) {
            return false;
        }

        return str_starts_with($url, $appUrl.'/') || $url === $appUrl;
    }
}
