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

    /** @test */
    public function it_shows_the_categories_details()
    {
        $category = $this->createCategory();

        $subcategory1 = $this->createSubcategory();

        $subcategory2 = $this->createCustomSubcategory('1', 'Tablets');

        $brand1 = $category->brands()->create(['name' => 'LG']);
        $brand2 = $category->brands()->create(['name' => 'Xiaomi']);

        $product1 = $this->createCustomProduct('Tablet LG2080', $subcategory2, $brand1, 2);
        $product2 = $this->createCustomProduct('Xiaomi A54',$subcategory1, $brand2,2);

        $this->browse(function (Browser $browser) use($category,$subcategory1, $subcategory2, $product1,$product2,$brand1, $brand2){

            $browser->visit('/')
                ->assertSee(strtoupper($category->name))
                ->assertSee('Ver más')
                ->click('.text-orange-500')
                ->assertSee($category->name)
                ->assertSee('Subcategorías')
                ->assertSeeIn('aside',ucwords($subcategory1->name))
                ->assertSeeIn('aside',ucwords($subcategory2->name))
                ->assertSeeIn('aside','Marcas')
                ->assertSeeIn('aside',ucfirst($brand1->name))
                ->assertSeeIn('aside',ucfirst($brand2->name))
                ->assertSeeIn('aside','ELIMINAR FILTROS')
                ->assertSee($product1->name)
                ->assertSee($product2->name)
                ->assertSee($product1->price)
                ->assertSee($product2->price)
                ->assertSee('€')
                ->assertPresent('img')
                ->assertPresent('h1.text-lg')
                ->assertPresent('p.font-bold')
                ->screenshot('categoriesDetails-test');
        });
    }

    /** @test */
    public function it_shows_at_least_5_products_from_a_category()
    {

        $products = $this->products();

        $this->browse(function (Browser $browser) use ($products) {
            foreach ($products as $product)
            $browser->visit('/')
                ->assertSee('Ver más')
                ->assertSee($product->name)
                ->screenshot('5_products_from_a_category-test');
        });
    }

    /** @test */
    public function it_shows_at_least_5_products_which_are_published_from_a_category()
    {
        $category = $this->createCategory();

        $subcategory = $this->createSubcategory();

        $brand = $category->brands()->create(['name' => 'LG']);

        $product1 = $this->createCustomProduct('LG2080', $subcategory, $brand, 2);
        $product2 = $this->createCustomProduct('LGK40', $subcategory, $brand, 2);
        $product3 = $this->createCustomProduct('LGQ60', $subcategory, $brand, 2);
        $product4 = $this->createCustomProduct('LGP40', $subcategory, $brand, 2);
        $product5 = $this->createCustomProduct('LGH90', $subcategory, $brand, 2);

        $product6 = $this->createCustomProduct('LGH4090', $subcategory, $brand, 1);
        $product7 = $this->createCustomProduct('LGH2050', $subcategory, $brand, 1);

        $category = strtoupper($category->name);

        $this->browse(function (Browser $browser) use ($category, $product1, $product2,
            $product3, $product4, $product5, $product6, $product7) {
            $browser->visit('/')
                ->assertSee($category)
                ->assertSee('Ver más')
                ->assertSee($product1->name)
                ->assertSee($product2->name)
                ->assertSee($product3->name)
                ->assertSee($product4->name)
                ->assertSee($product5->name)
                ->assertDontSee($product6->name)
                ->assertDontSee($product7->name)
                ->screenshot('5_published_products_from_a_category-test');
        });
    }

    /** @test */
    public function it_filters_by_subcategories()
    {
        $category = $this->createCategory();

        $subcategory1 = $this->createSubcategory();

        $subcategory2 = $this->createCustomSubcategory('1', 'Tablets');

        $brand = $category->brands()->create(['name' => 'LG']);

        $product1 = $this->createCustomProduct('LGP40', $subcategory1, $brand, 2);

        $product2 = $this->createCustomProduct('Tablet LGP80', $subcategory2, $brand, 2);

        $categoryTitle = $category->slug;

        $subcategory1 = ucwords($subcategory1->name);

        $this->browse(function (Browser $browser) use($categoryTitle,$subcategory1,
            $subcategory2, $product1, $product2){
            $browser->visit('/categories/' . $categoryTitle)
                ->click('li > a.cursor-pointer')
                ->assertSeeIn('aside', $subcategory1)
                ->assertSeeIn('aside', $subcategory2->name)
                ->assertSee($product1->name)
                ->assertDontSee($product2->name)
                ->screenshot('subcategoriesFilter-test');
        });
    }

    /** @test */
    public function it_filters_by_brands()
    {

        $category = $this->createCategory();

        $subcategory = $this->createSubcategory();

        $brand1 = $category->brands()->create(['name' => 'LG']);
        $brand2 = $category->brands()->create(['name' => 'Xiaomi']);

        $categoryTitle = $category->slug;

        $product1 = $this->createCustomProduct('LGP40', $subcategory, $brand1, 2);
        $product2 = $this->createCustomProduct('Xiaomi A54', $subcategory, $brand2, 2);


        $this->browse(function (Browser $browser) use($categoryTitle, $product1, $product2){
            $browser->visit('/categories/' . $categoryTitle)
                ->click('ul:nth-of-type(2) > li > a.cursor-pointer')
                ->assertPresent('a.font-semibold')
                ->assertSee($product1->name)
                ->assertDontSee($product2->name)
                ->screenshot('brandFilter-test');
        });
    }

    /** @test */
    public function it_filters_by_subcategories_and_brands()
    {
        $category = $this->createCategory();

        $subcategory1 = $this->createSubcategory();

        $subcategory2 = $this->createCustomSubcategory(1, 'Tablets');

        $brand1 = $category->brands()->create(['name' => 'LG']);
        $brand2 = $category->brands()->create(['name' => 'Xiaomi']);

        $categoryTitle = $category->slug;

        $product1 = $this->createCustomProduct('Móvil Xiaomi redmi note 8', $subcategory1, $brand1, 2);

        $product2 = $this->createCustomProduct('Tablet LG2070', $subcategory2, $brand2, 2);

        $this->browse(function (Browser $browser) use($categoryTitle,$product1, $product2){
            $browser->visit('/categories/' . $categoryTitle)
                ->click('li > a.cursor-pointer')
                ->click('ul:nth-of-type(2) > li:nth-of-type(1) > a.cursor-pointer')
                ->assertPresent('a.font-semibold')
                ->assertSee($product1->name)
                ->assertDontSee($product2->name)
                ->screenshot('categoryBrandFilter-test');
        });
    }
}
