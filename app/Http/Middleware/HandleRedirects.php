<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * HandleRedirects Middleware
 *
 * Memproses redirect yang tersimpan di database.
 *
 * KEAMANAN: destination_url divalidasi — HANYA mengizinkan:
 * 1. Path relatif (dimulai dengan /)          → aman, dalam situs sendiri
 * 2. URL HTTPS ke domain aplikasi sendiri     → aman
 *
 * URL ke domain lain (termasuk link judol) DITOLAK dan tidak akan
 * diteruskan sebagai redirect, mencegah penyalahgunaan fitur redirect
 * sebagai open redirect vulnerability.
 */
class HandleRedirects
{
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();

        if ($path === '/' || $request->getRequestUri() === '/') {
            return $next($request);
        }

        $path = '/'.ltrim($path, '/');

        $redirect = Redirect::where('source_url', $path)->where('is_active', true)->first();

        if ($redirect) {
            $destination = $redirect->destination_url;

            // Validasi keamanan: hanya izinkan path relatif atau URL ke domain sendiri
            if ($this->isSafeDestination($destination)) {
                $redirect->increment('hits');
                return redirect($destination, $redirect->status_code);
            }

            // Log potensi open-redirect abuse (destination tidak aman)
            logger()->warning('HandleRedirects: blocked unsafe destination_url', [
                'source'      => $path,
                'destination' => $destination,
                'ip'          => $request->ip(),
            ]);
        }

        return $next($request);
    }

    /**
     * Periksa apakah URL tujuan redirect aman.
     *
     * Aturan:
     * - Path relatif (dimulai '/') → AMAN
     * - URL HTTPS ke domain sendiri → AMAN
     * - URL ke domain lain (termasuk http://) → TIDAK AMAN
     */
    private function isSafeDestination(string $url): bool
    {
        // Path relatif selalu aman
        if (str_starts_with($url, '/') && !str_starts_with($url, '//')) {
            return true;
        }

        // URL absolut: hanya izinkan HTTPS ke domain sendiri
        $appUrl = rtrim(config('app.url', ''), '/');

        if (empty($appUrl)) {
            // Jika APP_URL tidak dikonfigurasi, hanya izinkan path relatif
            return false;
        }

        // Cek apakah URL dimulai dengan domain aplikasi kita
        if (str_starts_with($url, $appUrl . '/') || $url === $appUrl) {
            return true;
        }

        return false;
    }
}
