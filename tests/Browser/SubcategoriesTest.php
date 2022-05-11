<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SubcategoriesTest extends DuskTestCase
{
    /** @test */
    public function it_shows_the_subcategories_linked_to_phone_category()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Categorías')
                ->click('@categorias')
                ->assertSee('Celulares y tablets')
                ->mouseover('ul.bg-white > li:nth-of-type(1) > a')
                ->assertSee('Subcategorías')
                ->assertSee('Celulares y smartphones')
                ->assertSee('Accesorios para celulares')
                ->assertSee('Smartwatches')
                ->assertDontSee('Audios')
                ->assertDontSee('Xbox')
                ->assertDontSee('Almacenamiento')
                ->assertDontSee('Relojes')
                ->screenshot('phones-test');
        });
    }

    /** @test */
    public function it_shows_the_subcategories_linked_to_tv_category()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Categorías')
                ->click('@categorias')
                ->assertSee('TV, audio y video')
                ->mouseover('ul.bg-white > li:nth-of-type(2) > a')
                ->assertSee('Subcategorías')
                ->assertSee('TV y audio')
                ->assertSee('Audios')
                ->assertSee('Audio para autos')
                ->assertDontSee('Xbox')
                ->assertDontSee('Almacenamiento')
                ->assertDontSee('Relojes')
                ->screenshot('tvs-test');
        });
    }

    /** @test */
    public function it_shows_the_subcategories_linked_to_games_category()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Categorías')
                ->click('@categorias')
                ->assertSee('Consola y videojuegos')
                ->mouseover('ul.bg-white > li:nth-of-type(3) > a')
                ->assertSee('Subcategorías')
                ->assertSee('Xbox')
                ->assertSee('Play Station')
                ->assertSee('Videojuegos para PC')
                ->assertSee('Nintendo')
                ->assertDontSee('Audios')
                ->assertDontSee('Almacenamiento')
                ->assertDontSee('Relojes')
                ->screenshot('videogames-test');
        });
    }

    /** @test */
    public function it_shows_the_subcategories_linked_to_pc_category()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Categorías')
                ->click('@categorias')
                ->assertSee('Computación')
                ->mouseover('ul.bg-white > li:nth-of-type(4) > a')
                ->assertSee('Subcategorías')
                ->assertSee('Portátiles')
                ->assertSee('PC escritorio')
                ->assertSee('Almacenamiento')
                ->assertSee('Accesorios computadoras')
                ->assertDontSee('Audios')
                ->assertDontSee('Xbox')
                ->assertDontSee('Relojes')
                ->screenshot('videogames-test');
        });
    }

    /** @test */
    public function it_shows_the_subcategories_linked_to_fashion_category()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Categorías')
                ->click('@categorias')
                ->assertSee('Moda')
                ->mouseover('ul.bg-white > li:nth-of-type(5) > a')
                ->assertSee('Subcategorías')
                ->assertSee('Mujeres')
                ->assertSee('Hombres')
                ->assertSee('Lentes')
                ->assertSee('Relojes')
                ->assertDontSee('Audios')
                ->assertDontSee('Xbox')
                ->assertDontSee('Almacenamiento')
                ->screenshot('fashion-test');
        });
    }
}