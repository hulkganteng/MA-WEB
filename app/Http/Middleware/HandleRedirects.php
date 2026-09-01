<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use App\Support\UrlSanitizer;
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

            if (UrlSanitizer::isValidRedirectDestination($destination)) {
                $redirect->increment('hits');

                return redirect($destination, $redirect->status_code);
            }

            // Log potensi open-redirect abuse (destination tidak aman)
            logger()->warning('HandleRedirects: blocked unsafe destination_url', [
                'source' => $path,
                'destination' => $destination,
                'ip' => $request->ip(),
            ]);
        }

        return $next($request);
    }
}
