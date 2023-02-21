<?php

namespace Tests\Browser;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\CreateData;

class SubcategoriesTest extends DuskTestCase
{

    use DatabaseMigrations;
    use RefreshDatabase;
    use CreateData;

    /** @test */
    public function it_shows_the_subcategories_linked_to_a_category()
    {
        $category1 = $this->createCategory();

        $category2 = $this->createCustomCategory("Tv, audio y vídeo");

        $subcategory1 = $this->createSubcategory();

        $subcategory2 = $this->createCustomSubcategory(1,'Tablets');

        $hiddenSubcategory1 = $this->createCustomSubcategory(2,'Video');

        $hiddenSubcategory2 = $this->createCustomSubcategory(2,'Audio');

        $this->browse(function (Browser $browser) use ($category1,$category2, $subcategory1, $subcategory2,$hiddenSubcategory1,$hiddenSubcategory2){
            $browser->visit('/')
                ->pause(100)
                ->assertSee('Categorías')
                ->pause(100)
                ->click('@categorias')
                ->pause(100)
                ->assertSee($category1->name)
                ->pause(100)
                ->mouseover('ul.bg-white > li:nth-of-type(1) > a')
                ->pause(100)
                ->assertSee('Subcategorías')
                ->pause(100)
                ->assertSee($subcategory1->name)
                ->pause(100)
                ->assertSee($subcategory2->name)
                ->pause(100)
                ->assertSee($category2->name)
                ->pause(100)
                ->assertDontSee($hiddenSubcategory1->name)
                ->pause(100)
                ->assertDontSee($hiddenSubcategory2->name)
                ->screenshot('subcategory-test');
        });
    }
}
