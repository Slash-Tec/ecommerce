<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Spatie\Permission\Models\Role;
use Tests\CreateData;

class SearchTest extends DuskTestCase
{

    use DatabaseMigrations;
    use RefreshDatabase;
    use CreateData;

    /** @test */
    public function it_searchs_by_product_name()
    {
        $product = $this->createProduct();
        $this->createProducts(3);

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/')
                ->type('input', $product->name)
                ->pause(1000)
                ->assertSeeIn('div.px-4',$product->name)
                ->screenshot('searchByName-test');
        });
    }

    /** @test */
    public function it_searchs_by_product_name_in_admin_zone()
    {
        $product = $this->createProduct();
        $this->createProducts(5);

        $user = $this->createAdmin();

        $this->browse(function (Browser $browser) use ($product, $user) {
            $browser->loginAs($user->id)
                ->visit('/admin')
                ->pause(1000)
                ->type('input.border-gray-300', $product->name)
                ->pause(1000)
                ->assertSeeIn('tbody',$product->name)
                ->screenshot('searchByNameAdmin-test');
        });
    }
}
