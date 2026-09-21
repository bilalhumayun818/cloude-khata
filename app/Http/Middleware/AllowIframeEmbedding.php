<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Utils\BusinessUtil;

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
        // Auto-login demo user for iframe previews if unauthenticated
        if (! Auth::check()) {
            $demoUser = User::first();
            if ($demoUser) {
                Auth::login($demoUser);

                $business_util = new BusinessUtil();
                $business = \App\Business::find($demoUser->business_id);
                if ($business) {
                    $currency = $business->currency;
                    $currency_data = [
                        'id' => $currency->id ?? 1,
                        'code' => $currency->code ?? 'USD',
                        'symbol' => $currency->symbol ?? '$',
                        'thousand_separator' => $currency->thousand_separator ?? ',',
                        'decimal_separator' => $currency->decimal_separator ?? '.',
                    ];

                    session([
                        'user' => [
                            'id' => $demoUser->id,
                            'surname' => $demoUser->surname,
                            'first_name' => $demoUser->first_name,
                            'last_name' => $demoUser->last_name,
                            'email' => $demoUser->email,
                            'business_id' => $demoUser->business_id,
                            'language' => $demoUser->language,
                        ],
                        'business' => $business,
                        'currency' => $currency_data,
                        'financial_year' => $business_util->getCurrentFinancialYear($business->id),
                    ]);
                }
            }
        }

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
