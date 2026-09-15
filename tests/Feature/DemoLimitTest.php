<?php

namespace Tests\Feature;

use App\Http\Middleware\CheckDemoLimit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class DemoLimitTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $user = new User;
        $user->id = 123;
        $user->business_id = 456;
        $this->actingAs($user);
        session(['is_demo' => true, 'demo_user_id' => 123, 'demo_business_id' => 456]);
    }

    private function perform($path = '/products', $action = 'store', $success = true, $method = 'POST')
    {
        $request = Request::create($path, $method);
        $request->headers->set('Accept', 'application/json');
        $request->setRouteResolver(function () use ($method, $path, $action) {
            return new Route($method, $path, [
                'uses' => 'ExampleController@'.$action,
                'controller' => 'ExampleController@'.$action,
            ]);
        });

        return (new CheckDemoLimit)->handle($request, function () use ($success) {
            return response()->json(['success' => $success]);
        });
    }

    public function test_ten_successes_are_allowed_per_feature_and_eleventh_is_blocked()
    {
        for ($i = 0; $i < 10; $i++) {
            $this->assertTrue($this->perform()->getData(true)['success']);
        }
        $this->assertTrue($this->perform()->getData(true)['demo_limit_reached']);
        $this->assertTrue($this->perform('/contacts')->getData(true)['success']);
        $this->assertSame(10, session('demo_action_counts.products'));
        $this->assertSame(1, session('demo_action_counts.contacts'));
    }

    public function test_failures_and_form_lookups_do_not_consume_allowance()
    {
        $this->perform('/products', 'store', false);
        $this->perform('/products/get_sub_categories', 'getSubCategories');
        $this->perform('/products/check_product_sku', 'checkProductSku');
        $this->perform('/products', 'index', true, 'GET');
        $this->assertNull(session('demo_action_counts.products'));
    }

    public function test_regular_accounts_and_mismatched_demo_business_are_unchanged()
    {
        session(['is_demo' => false, 'demo_action_counts.products' => 10]);
        $this->assertTrue($this->perform()->getData(true)['success']);
        session(['is_demo' => true, 'demo_business_id' => 999]);
        $this->assertTrue($this->perform()->getData(true)['success']);
        $this->assertSame(10, session('demo_action_counts.products'));
    }

    public function test_demo_usernames_have_business_specific_extension()
    {
        $this->assertSame('-demo-456', (new \App\Utils\Util)->getUsernameExtension());
    }
}
