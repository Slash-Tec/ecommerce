<?php

namespace Tests\Browser;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CategoriesTest extends DuskTestCase
{

    /** @test */
    public function it_shows_the_categories()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Categorías')
                    ->click('@categorias')
                ->assertSee('Celulares y tablets')
                ->assertSee('TV, audio y video')
                ->assertSee('Consola y videojuegos')
                ->assertSee('Computación')
                ->assertSee('Moda')
                    ->screenshot('example-test');
        });
    }
}