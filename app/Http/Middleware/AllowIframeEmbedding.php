<?php

namespace App\Http\Middleware;

use Closure;

class AllowIframeEmbedding
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (method_exists($response, 'header')) {
            $response->header('X-Frame-Options', 'ALLOWALL');
            $response->header('Content-Security-Policy', "frame-ancestors 'self' https://www.broshtech.com https://broshtech.com http://localhost:* http://127.0.0.1:*");
        } elseif (property_exists($response, 'headers')) {
            $response->headers->remove('X-Frame-Options');
            $response->headers->set('Content-Security-Policy', "frame-ancestors 'self' https://www.broshtech.com https://broshtech.com http://localhost:* http://127.0.0.1:*");
        }

        return $response;
    }
}
