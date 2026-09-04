<?php

namespace Tests\Feature;

use Tests\TestCase;

class SoftwareCatalogTest extends TestCase
{
    public function testCatalogListsAllSixProducts()
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Cloud Khata')
            ->assertSee('Vendify')
            ->assertSee('CX Couriers')
            ->assertSee('DOMS')
            ->assertSee('RMS')
            ->assertSee('Paddle')
            ->assertDontSee('Sign in')
            ->assertDontSee('Orders today')
            ->assertDontSee('Running smoothly');
    }

    /** @dataProvider productProvider */
    public function testEachProductHasItsOwnDetailPage($slug, $name)
    {
        $this->get("/software/{$slug}")
            ->assertOk()
            ->assertSee($name)
            ->assertSee('Buy now');
    }

    public function testVendifyLinksToTheLiveDemo()
    {
        $this->get('/software/vendify')
            ->assertOk()
            ->assertSee('https://pos.broshtech.com/', false)
            ->assertSee('Open live demo');
    }

    public function testUnknownSoftwareReturnsNotFound()
    {
        $this->get('/software/not-a-product')->assertNotFound();
    }

    public function testAllProductsUseTheMonochromePalette()
    {
        $products = config('software.products');

        foreach ($products as $product) {
            $this->assertSame('#222222', $product['color']);
            $this->assertSame('#ececea', $product['soft_color']);
            $this->assertSame('#d6d6d2', $product['secondary_color']);
        }
    }

    public function productProvider()
    {
        return [
            ['cloud-khata', 'Cloud Khata'],
            ['vendify', 'Vendify'],
            ['cx-couriers', 'CX Couriers'],
            ['doms', 'DOMS'],
            ['rms', 'RMS'],
            ['paddle', 'Paddle'],
        ];
    }
}
