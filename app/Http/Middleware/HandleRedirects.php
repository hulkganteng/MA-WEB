<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
            $redirect->increment('hits');

            return redirect($redirect->destination_url, $redirect->status_code);
        }

        return $next($request);
    }
}
