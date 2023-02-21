<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\CreateData;

class ShoppingCartTest extends DuskTestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    use CreateData;

    /** @test */
    public function the_red_circle_of_the_cart_increases_when_adding_a_product()
    {
        $this->createProduct();

        $this->browse(function (Browser $browser){
            $browser->visit('/')
                ->pause(100)
                ->click('h1.text-lg > a')
                ->pause(100)
                ->click('div.flex-1 > button')
                ->pause(100)
                ->assertSeeIn('span.relative > span.absolute','1')
                ->screenshot('redCircleIncreasesWhenAddingProduct-test');
        });
    }

    /** @test */
    public function it_is_possible_to_add_a_color_product()
    {
        $this->createColorProduct();

        $this->browse(function (Browser $browser){
            $browser->visit('/')
                ->pause(100)
                ->click('h1.text-lg > a')
                ->pause(100)
                ->click('select.form-control')
                ->pause(100)
                ->click('option:nth-of-type(2)')
                ->pause(100)
                ->click('div.flex-1 > button')
                ->pause(100)
                ->assertSeeIn('span.relative > span.absolute','1')
                ->screenshot('addingColorProduct-test');
        });
    }

    /** @test */
    public function it_is_possible_to_add_a_size_color_product()
    {
        $this->createColorSizeProduct();

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(100)
                ->click('h1.text-lg > a')
                ->pause(100)
                ->click('div > select')
                ->pause(100)
                ->click('div > select > option:nth-of-type(2)')
                ->pause(1000)
                ->click('div.mt-2 > select')
                ->pause(100)
                ->click('div.mt-2 > select > option:nth-of-type(2)')
                ->pause(100)
                ->click('div.flex-1 > button')
                ->pause(100)
                ->assertSeeIn('span.relative > span.absolute','1')
                ->screenshot('addingSizeColorProduct-test');
        });
    }

    /** @test */
    public function it_shows_the_products_added_to_cart()
    {
        $product = $this->createProduct();

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/')
                ->pause(100)
                ->click('h1.text-lg > a')
                ->pause(100)
                ->click('div.flex-1 > button')
                ->pause(100)
                ->click('div.relative > div > span')
                ->pause(100)
                ->assertSeeIn('li.flex', $product->name)
                ->pause(100)
                ->assertSeeIn('li.flex', $product->price)
                ->screenshot('redCircleIncreasesWhenAddingProduct-test');
        });
    }

    /** @test */
    public function it_is_not_possible_to_add_products_that_are_out_of_stock()
    {
        $product = $this->createProduct();
        $product->quantity = 0;
        $product->save();

        $this->browse(function (Browser $browser){
            $browser->visit('/')
                ->pause(100)
                ->click('h1.text-lg > a')
                ->pause(100)
                ->assertButtonDisabled('AGREGAR AL CARRITO DE COMPRAS')
                ->screenshot('notPossibleAddProductsWhenOutOfStock-test');
        });
    }

    /** @test */
    public function it_is_not_possible_to_add_color_products_that_are_out_of_stock()
    {
        $this->createOutOfStockColorProduct();

        $this->browse(function (Browser $browser){
            $browser->visit('/')
                ->pause(100)
                ->click('h1.text-lg > a')
                ->pause(100)
                ->click('select.form-control')
                ->pause(100)
                ->click('option:nth-of-type(2)')
                ->pause(100)
                ->assertButtonDisabled('AGREGAR AL CARRITO DE COMPRAS')
                ->screenshot('outStockColorProducts-test');
        });
    }

    /** @test */
    public function it_is_not_possible_to_add_size_color_products_that_are_out_of_stock()
    {
        $this->createOutStockColorSizeProduct();

        $this->browse(function (Browser $browser){
            $browser->visit('/')
                ->pause(100)
                ->click('h1.text-lg > a')
                ->pause(100)
                ->click('div > select')
                ->pause(100)
                ->click('div > select > option:nth-of-type(2)')
                ->pause(1000)
                ->click('div.mt-2 > select')
                ->pause(100)
                ->click('div.mt-2 > select > option:nth-of-type(2)')
                ->pause(100)
                ->assertButtonDisabled('AGREGAR AL CARRITO DE COMPRAS')
                ->screenshot('outStockSizeColorProducts-test');
        });
    }

    /** @test */
    public function it_shows_the_products_in_the_cart_view()
    {
        $product = $this->createProduct();

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/')
                ->pause(100)
                ->click('h1.text-lg > a')
                ->pause(100)
                ->click('div.flex-1 > button')
                ->pause(100)
                ->click('div.relative > div > span')
                ->pause(100)
                ->click('div.px-3 > a.inline-flex')
                ->assertSee('CARRITO DE COMPRAS')
                ->assertSee($product->name)
                ->pause(100)
                ->assertSee($product->price)
                ->pause(100)
                ->assertPathIs('/shopping-cart')
                ->screenshot('cartView-test');
        });
    }

    /** @test */
    public function it_calculates_the_total_when_increasing_the_quantity_in_the_cart_view()
    {
        $product = $this->createProduct();

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/')
                ->pause(100)
                ->click('h1.text-lg > a')
                ->pause(100)
                ->click('div.flex-1 > button')
                ->pause(100)
                ->click('div.relative > div > span')
                ->pause(100)
                ->click('div.px-3 > a.inline-flex')
                ->assertSee($product->name)
                ->pause(100)
                ->click('div.flex > button:nth-of-type(2)')
                ->pause(100)
                ->assertSeeIn('.text-sm .text-gray-500',$product->price*2 . " €")
                ->pause(100)
                ->screenshot('calculateCartView-test');
        });
    }

    /** @test */
    public function it_is_possible_to_flush_the_shopping_cart()
    {
        $product = $this->createProduct();

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/')
                ->pause(100)
                ->click('h1.text-lg > a')
                ->pause(100)
                ->click('div.flex-1 > button')
                ->pause(100)
                ->click('div.relative > div > span')
                ->pause(100)
                ->click('div.px-3 > a.inline-flex')
                ->assertSee($product->name)
                ->pause(100)
                ->click('.text-sm .cursor-pointer')
                ->pause(100)
                ->assertSee("TU CARRITO DE COMPRAS ESTÁ VACÍO")
                ->pause(100)
                ->assertSee("IR AL INICIO")
                ->assertPresent('a.inline-flex')
                ->screenshot('flushCartView-test');
        });
    }

    /** @test */
    public function it_is_possible_to_remove_a_product_from_the_shopping_cart()
    {
        $product = $this->createProduct();

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/')
                ->pause(100)
                ->click('h1.text-lg > a')
                ->pause(100)
                ->click('div.flex-1 > button')
                ->pause(100)
                ->click('div.relative > div > span')
                ->pause(100)
                ->click('div.px-3 > a.inline-flex')
                ->assertSee($product->name)
                ->pause(100)
                ->click('svg.fa-trash')
                ->pause(100)
                ->assertSee("TU CARRITO DE COMPRAS ESTÁ VACÍO")
                ->pause(100)
                ->assertSee("IR AL INICIO")
                ->assertPresent('a.inline-flex')
                ->screenshot('removeProductCartView-test');
        });
    }

    /** @test */
    public function it_saves_the_shopping_cart_when_user_logs_out()
    {
        $product = $this->createProduct();
        $user = $this->createUser();

        $this->browse(function (Browser $browser) use($product, $user){
            $browser->loginAs($user->id)
                ->visit('/dashboard')
                ->pause(100)
                ->click('a.mx-6')
                ->pause(100)
                ->click('h1.text-lg > a')
                ->pause(100)
                ->click('div.flex-1 > button')
                ->pause(100)
                ->click('div.relative > div > span')
                ->pause(100)
                ->assertSeeIn('li.flex', $product->name)
                ->logout()
                ->loginAs($user->id)
                ->visit('/')
                ->click('div.relative > div > span')
                ->pause(100)
                ->assertSeeIn('li.flex', $product->name)
                ->screenshot('savesCart-test');
        });
    }
}
