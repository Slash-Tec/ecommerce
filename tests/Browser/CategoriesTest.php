<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\CreateData;


class CategoriesTest extends DuskTestCase
{

    use DatabaseMigrations;
    use RefreshDatabase;
    use CreateData;

    /** @test */
    public function it_shows_the_categories()
    {
        $categories = $this->createCategories();

        $this->browse(function (Browser $browser) use($categories){
            foreach ($categories as $category)

                $browser->visit('/')
                    ->pause(100)
                    ->assertSee('Categorías')
                    ->pause(100)
                    ->click('@categorias')
                    ->pause(100)
                    ->assertSee($category->name)
                    ->screenshot('showsCategories');
        });
    }
}
