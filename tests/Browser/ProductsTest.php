<?php

namespace Tests\Browser;

use App\Models\Color;
use App\Models\Size;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\CreateData;

class ProductsTest extends DuskTestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;
    use CreateData;

    /** @test */
    public function the_products_details_are_shown()
    {
        $product = $this->createProduct();
        $product->images()->create(['url' => 'storage/324234324323423.png']);

        $this->browse(function (Browser $browser) use($product) {
            $browser->visit('products/' . $product->id)
                ->assertSee($product->name)
                    ->assertSee('Marca: ' . ucfirst($product->brand()->first()->name))
                    ->assertPresent('a.underline')
                    ->assertSee($product->price)
                    ->assertPresent('p.text-2xl')
                    ->assertSee('Stock disponible: ' . $product->quantity)
                    ->assertPresent('span.font-semibold ')
                    ->assertButtonEnabled('+')
                    ->assertButtonDisabled('-')
                    ->assertButtonEnabled('AGREGAR AL CARRITO DE COMPRAS')
                ->assertSee($product->description)
                ->assertPresent('div.flexslider')
                ->assertPresent('img.flex-active')
                ->screenshot('productDetails-test');
        });
    }

    /** @test */
    public function the_color_products_details_are_shown()
    {
        $product = $this->createColorProduct();
        $product->images()->create(['url' => 'storage/324234324323423.png']);

        $this->browse(function (Browser $browser) use($product) {
            $browser->visit('products/' . $product->id)
                ->assertSee($product->name)
                ->assertSee('Marca: ' . ucfirst($product->brand()->first()->name))
                ->assertPresent('a.underline')
                ->assertSee($product->price)
                ->assertPresent('p.text-2xl')
                ->assertSee('Stock disponible: ' . $product->quantity)
                ->assertPresent('span.font-semibold ')
                ->assertButtonDisabled('+')
                ->assertButtonDisabled('-')
                ->assertButtonDisabled('AGREGAR AL CARRITO DE COMPRAS')
                ->assertSee($product->description)
                ->assertPresent('div.flexslider')
                ->assertPresent('img.flex-active')
                ->screenshot('colorProductDetails-test');
        });
    }

    /** @test */
    public function the_size_color_products_details_are_shown()
    {
        $product = $this->createColorSizeProduct();

        $this->browse(function (Browser $browser) use($product) {
            $browser->visit('products/' . $product->id)
                ->assertSee($product->name)
                ->assertSee('Marca: ' . ucfirst($product->brand()->first()->name))
                ->assertPresent('a.underline')
                ->assertSee($product->price)
                ->assertPresent('p.text-2xl')
                ->assertSee('Stock disponible: ' . $product->quantity)
                ->assertPresent('span.font-semibold ')
                ->assertButtonDisabled('+')
                ->assertButtonDisabled('-')
                ->assertButtonDisabled('AGREGAR AL CARRITO DE COMPRAS')
                ->assertSee($product->description)
                ->assertPresent('div.flexslider')
                ->screenshot('sizeColorProductDetails-test');
        });
    }

    /** @test */
    public function the_button_limits_are_ok()
    {
        $product = $this->createProduct();
        $product->quantity = '2';
        $product->save();

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('products/' . $product->id)
                ->assertButtonDisabled('-')
                ->assertButtonEnabled('+')
                ->click('div.mr-4 > button:nth-of-type(2)')
                ->assertButtonDisabled('+')
                ->assertButtonEnabled('-')
                ->assertButtonEnabled('AGREGAR AL CARRITO DE COMPRAS')
                ->screenshot('buttonLimits-test');
        });
    }

    /** @test */
    public function it_is_possible_to_access_the_detail_view_of_a_product()
    {
       $product = $this->createProduct();

        $this->browse(function (Browser $browser) use($product){
            $browser->visit('products/' . $product->id)
                ->assertUrlIs('http://localhost:8000/products/' . $product->id)
                ->screenshot('productDetailsAccess-test');
        });


        $this->browse(function (Browser $browser) use($product) {
            $browser->visit('/')
                ->click('@categorias')
                ->assertSee($product->name)
                ->click('ul.bg-white > li > a')
                ->click('li > article > div.py-4 > h1 > a')
                ->assertUrlIs('http://localhost:8000/products/' . $product->id)
                ->screenshot('productDetailsAccess2-test');
        });
    }

    /** @test */
    public function the_color_and_size_dropdowns_are_shown_according_to_the_chosen_product()
    {
        $product = $this->createColorProduct();

        $this->get('products/' . $product->id)
            ->assertSeeLivewire('add-cart-item-color');

        $this->browse(function (Browser $browser) use($product) {
            $browser->visit('products/' . $product->id)
                ->assertSee('Color:')
                ->assertPresent('select.form-control')
                ->screenshot('colorDropdown-test');
        });

        $sizeProduct = $this->createColorSizeProduct();

        $this->get('products/' . $sizeProduct->id)
            ->assertSeeLivewire('add-cart-item-size');

        $this->browse(function (Browser $browser) use($sizeProduct) {
            $browser->visit('products/' . $sizeProduct->id)
                ->assertSee('Color:')
                ->assertSee('Talla:')
                ->assertPresent('div > select')
                ->assertPresent('div.mt-2 > select')
                ->screenshot('colorSizeDropdown-test');
        });
    }

    /** @test */
    public function the_available_stock_of_a_product_changes()
    {
        $product = $this->createProduct();

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('products/' . $product->id)
                ->click('div.mr-4 > button:nth-of-type(2)')
                ->press('AGREGAR AL CARRITO')
                ->assertSeeIn('div.items-center > div > p.text-gray-700 > span','Stock disponible:')
                ->assertSeeIn('div.items-center > div > p.text-gray-700', ($product->quantity-2))
                ->screenshot('stockProductChanges-test');
        });
    }

    /** @test */
    public function the_available_stock_of_a_color_product_changes()
    {
        $product = $this->createColorProduct();

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('products/' . $product->id)
                ->click('select.form-control')
                ->pause(100)
                ->click('option:nth-of-type(2)')
                ->pause(100)
                ->click('div.mr-4 > button:nth-of-type(2)')
                ->pause(100)
                ->press('AGREGAR AL CARRITO')
                ->assertSeeIn('div.items-center > div > p.my-4 > span','Stock disponible:')
                ->assertSee($product->quantity -2)
                ->screenshot('stockColorProductChanges-test');
        });
    }

    /** @test */
    public function the_available_stock_of_a_color_size_product_changes()
    {
        $product = $this->createColorSizeProduct();

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('products/' . $product->id)
                ->click('div > select')
                ->pause(100)
                ->click('div > select > option:nth-of-type(2)')
                ->pause(1000)
                ->click('div.mt-2 > select')
                ->pause(100)
                ->click('div.mt-2 > select > option:nth-of-type(2)')
                ->pause(100)
                ->click('div.mr-4 > button:nth-of-type(2)')
                ->press('AGREGAR AL CARRITO')
                ->assertSeeIn('div.items-center > div > p.text-gray-700 > span','Stock disponible:')
                ->pause(100)
                ->assertSee(($product->quantity-2))
                ->screenshot('stockColorSizeProductChanges-test');
        });
    }
}
