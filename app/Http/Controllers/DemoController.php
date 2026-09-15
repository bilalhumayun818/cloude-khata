<?php

namespace App\Http\Controllers;

use App\User;
use App\Utils\BusinessUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemoController extends Controller
{
    /**
     * Start/Enter Demo Mode.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        // Set Demo Mode session flags
        session(['is_demo' => true]);

        if (! session()->has('demo_action_counts')) {
            session(['demo_action_counts' => []]);
        }

        $business_util = new BusinessUtil();

        $demoUser = session()->has('demo_user_id')
            ? User::where('business_id', session('demo_business_id'))->find(session('demo_user_id'))
            : null;
        if (! $demoUser) {
            session(['demo_action_counts' => []]);
            $rand = \Illuminate\Support\Str::random(5);
            
            // Create temporary demo user first to satisfy owner_id foreign key constraint
            $owner_details = [
                'surname' => 'Mr',
                'first_name' => 'Demo',
                'last_name' => 'User ' . $rand,
                'username' => 'demo_' . $rand,
                'email' => 'demo_' . $rand . '@example.com',
                'password' => '12345678',
                'language' => 'en'
            ];
            $demoUser = User::create_user($owner_details);

            // Create temporary demo business
            $business_details = [
                'name' => 'Demo Business ' . $rand,
                'currency_id' => 1,
                'time_zone' => 'Asia/Kolkata',
                'fy_start_month' => 1,
                'accounting_method' => 'fifo',
                'sell_price_tax' => 'includes',
                'default_profit_percent' => 25,
                'owner_id' => $demoUser->id,
            ];
            $business = $business_util->createNewBusiness($business_details);

            $demoUser->business_id = $business->id;
            $demoUser->save();

            $business_util->newBusinessDefaultResources($business->id, $demoUser->id);

            $business_location = [
                'name' => 'Demo Location',
                'country' => 'Demo Country',
                'state' => 'Demo State',
                'city' => 'Demo City',
                'zip_code' => '12345',
                'landmark' => '',
                'website' => '',
                'mobile' => '',
                'alternate_number' => ''
            ];
            $new_location = $business_util->addLocation($business->id, $business_location);
            \Spatie\Permission\Models\Permission::create(['name' => 'location.'.$new_location->id]);

            session(['demo_user_id' => $demoUser->id, 'demo_business_id' => $business->id]);
        }

        if ($demoUser) {
            Auth::login($demoUser);
            
            // Trigger session setup
            $session_data = [
                'id' => $demoUser->id,
                'surname' => $demoUser->surname,
                'first_name' => $demoUser->first_name,
                'last_name' => $demoUser->last_name,
                'email' => $demoUser->email,
                'business_id' => $demoUser->business_id,
                'language' => $demoUser->language,
            ];
            
            $business = \App\Business::find($demoUser->business_id);
            if ($business) {
                $business->enabled_modules = array_keys((new \App\Utils\ModuleUtil())->availableModules());
                $business->save();
                $currency = $business->currency;
                $currency_data = [
                    'id' => $currency->id ?? 1,
                    'code' => $currency->code ?? 'USD',
                    'symbol' => $currency->symbol ?? '$',
                    'thousand_separator' => $currency->thousand_separator ?? ',',
                    'decimal_separator' => $currency->decimal_separator ?? '.',
                ];

                session([
                    'user' => $session_data,
                    'business' => $business,
                    'currency' => $currency_data,
                    'financial_year' => $business_util->getCurrentFinancialYear($business->id),
                ]);
            }
        }

        return redirect()->route('home')->with('status', [
            'success' => 1,
            'msg' => __('Welcome to Demo Mode! You can perform 10 successful actions per feature. Your session is fully isolated.'),
        ]);
    }

    /**
     * Exit Demo Mode.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function exit(Request $request)
    {
        // Delete the temporary demo business and user
        if (session()->has('demo_business_id')) {
            try {
                \App\Business::where('id', session('demo_business_id'))->delete();
            } catch (\Exception $e) { }
        }
        if (session()->has('demo_user_id')) {
            try {
                \App\User::where('id', session('demo_user_id'))->delete();
            } catch (\Exception $e) { }
        }

        // Clear all demo and user session data
        request()->session()->flush();
        Auth::logout();

        return redirect('/')->with('status', [
            'success' => 1,
            'msg' => __('Exited Demo Mode successfully.'),
        ]);
    }
}
