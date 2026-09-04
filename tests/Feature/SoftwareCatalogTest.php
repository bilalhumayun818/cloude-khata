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
            ->assertDontSee('Sign in');
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

    public function testProductBrandColorsMatchTheRequestedPalette()
    {
        $products = config('software.products');

        $this->assertSame('#eab308', $products['vendify']['color']);
        $this->assertSame('#f97316', $products['rms']['color']);
        $this->assertSame('#111111', $products['paddle']['color']);
        $this->assertSame('#a3e635', $products['paddle']['secondary_color']);
        $this->assertSame('#2563eb', $products['cloud-khata']['color']);
        $this->assertSame('#2563eb', $products['cx-couriers']['color']);
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
