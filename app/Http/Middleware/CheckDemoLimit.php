<?php

namespace App\Http\Middleware;

use Closure;

class CheckDemoLimit
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
        // Check if current session is in Demo Mode and user is the demo user
        if (session('is_demo') && auth()->check() && session('demo_user_id') == auth()->id()
            && session('demo_business_id') == auth()->user()->business_id) {
            // Count creation/modification actions (POST, PUT, PATCH, DELETE)
            if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
                
                // Allow exit and auth routes without counting
                if ($request->is('demo/exit') || $request->is('logout') || $request->is('login')) {
                    return $next($request);
                }

                // Form lookups and validation are reads even when sent via POST.
                $action = $request->route() ? $request->route()->getActionMethod() : '';
                if (preg_match('/^(get|check|validate|refresh|postCheck)/', $action)
                    || in_array($action, ['bulkEdit', 'preview'])) {
                    return $next($request);
                }

                $feature = $request->segment(1) ?: 'general';
                $counts = session('demo_action_counts', []);
                $current_count = isset($counts[$feature]) ? $counts[$feature] : 0;

                if ($current_count >= 10) {
                    $error_msg = __('Demo limit reached! You cannot perform more than 10 actions for this feature ('.ucfirst($feature).').');

                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json([
                            'success' => false,
                            'msg' => $error_msg,
                            'demo_limit_reached' => true,
                        ]);
                    }

                    return redirect()->back()
                        ->with('status', [
                            'success' => 0,
                            'msg' => $error_msg,
                        ])
                        ->with('demo_limit_reached', true);
                }

                $response = $next($request);
                $successful = $response->getStatusCode() < 400;
                if ($response instanceof \Illuminate\Http\JsonResponse) {
                    $data = $response->getData(true);
                    if (is_array($data) && array_key_exists('success', $data)) {
                        $successful = $successful && (bool) $data['success'];
                    }
                }
                if ($response->isRedirection()) {
                    $status = session('status');
                    $successful = $successful && ! session()->has('errors')
                        && is_array($status) && ! empty($status['success']);
                }
                if ($successful) {
                    session(['demo_action_counts.'.$feature => $current_count + 1]);
                }

                return $response;
            }
        }

        return $next($request);
    }
}
