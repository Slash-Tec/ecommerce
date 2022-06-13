<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\CreateData;

class FilterTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    use CreateData;

    /** @test */
    public function it_searchs_a_product()
    {
        $admin = $this->createAdmin();
        $category = $this->createCategory();
        $subcategory = $this->createSubcategory();
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Cascos', $subcategory, $brand, '2');
        $product1 = $this->createProduct();

        $this->actingAs($admin)->get('/admin/products2?search=Casc')
            ->assertOk()
            ->assertSee($product->name)
            ->assertDontSee($product1->name);
    }

    /** @test */
    public function it_filters_by_category()
    {
        $admin = $this->createAdmin();
        $product1 = $this->createProduct();
        $category = $this->createCustomCategory('Altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Altavoces portátiles');
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Altavoz', $subcategory, $brand, '2');


        $this->actingAs($admin)->get('/admin/products2?category=2')
            ->assertOk()
            ->assertSee($product->name)
            ->assertSee($category->name)
            ->assertDontSee($product1->name);
    }

    /** @test */
    public function it_filters_by_subcategory()
    {
        $admin = $this->createAdmin();
        $category = $this->createCustomCategory('Altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Altavoces portátiles');
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Altavoz', $subcategory, $brand, '2');
        $product1 = $this->createProduct();

        $this->actingAs($admin)->get('/admin/products2?subcategory=1')
            ->assertOk()
            ->assertSee($product->name)
            ->assertSee($subcategory->name)
            ->assertDontSee($product1->name);
    }

    /** @test */
    public function it_filters_by_brand()
    {
        $admin = $this->createAdmin();
        $category = $this->createCustomCategory('Altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Altavoces portátiles');
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Altavoz', $subcategory, $brand, '2');
        $product1 = $this->createProduct();

        $this->actingAs($admin)->get('/admin/products2?brand=1')
            ->assertOk()
            ->assertSee($product->name)
            ->assertSee($brand->name)
            ->assertDontSee($product1->name);
    }

    /** @test */
    public function it_filters_by_created_from_date()
    {
        $admin = $this->createAdmin();
        $category = $this->createCustomCategory('Altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Altavoces portátiles');
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Altavoz', $subcategory, $brand, '2');
        $product->created_at = '2022-02-06 14:28:10';
        $product->save();
        $product1 = $this->createProduct();
        $product1->created_at = '2022-02-04 14:28:10';
        $product1->save();

        $this->actingAs($admin)->get('/admin/products2?from=06%2F02%2F2022')
            ->assertOk()
            ->assertSee($product->name)
            ->assertSee($product->created_at)
            ->assertDontSee($product1->name);
    }

    /** @test */
    public function it_filters_by_created_to_date()
    {
        $admin = $this->createAdmin();
        $category = $this->createCustomCategory('Altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Altavoces portátiles');
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Altavoz', $subcategory, $brand, '2');
        $product->created_at = '2022-02-06 14:28:10';
        $product->save();
        $product1 = $this->createProduct();
        $product1->created_at = '2022-02-07 14:28:10';
        $product1->save();

        $this->actingAs($admin)->get('/admin/products2?to=06%2F02%2F2022')
            ->assertOk()
            ->assertSee($product->name)
            ->assertSee($product->created_at)
            ->assertDontSee($product1->name);
    }

    /** @test */
    public function it_filters_by_created_from_to_date()
    {
        $admin = $this->createAdmin();
        $category = $this->createCustomCategory('Altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Altavoces portátiles');
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Altavoz', $subcategory, $brand, '2');
        $product->created_at = '2022-02-06 14:28:10';
        $product->save();
        $product1 = $this->createProduct();
        $product1->created_at = '2022-02-04 14:28:10';
        $product1->save();

        $this->actingAs($admin)->get('/admin/products2?from=06%2F02%2F2022&to=08%2F02%2F2022')
            ->assertOk()
            ->assertSee($product->name)
            ->assertSee($product->created_at)
            ->assertDontSee($product1->name);
    }

    /** @test */
    public function it_filters_by_min_price()
    {
        $admin = $this->createAdmin();
        $category = $this->createCustomCategory('Altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Altavoces portátiles');
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Altavoz', $subcategory, $brand, '2');
        $product->price = '19.99';
        $product->save();
        $product1 = $this->createProduct();
        $product1->price = '19.98';
        $product1->save();

        $this->actingAs($admin)->get('/admin/products2?minPrice=19.99')
            ->assertOk()
            ->assertSee($product->name)
            ->assertSee($product->price)
            ->assertDontSee($product1->name);
    }

    /** @test */
    public function it_filters_by_max_price()
    {
        $admin = $this->createAdmin();
        $category = $this->createCustomCategory('Altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Altavoces portátiles');
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Altavoz', $subcategory, $brand, '2');
        $product->price = '19.98';
        $product->save();
        $product1 = $this->createProduct();
        $product1->price = '19.99';
        $product1->save();

        $this->actingAs($admin)->get('/admin/products2?maxPrice=19.98')
            ->assertOk()
            ->assertSee($product->name)
            ->assertSee($product->price)
            ->assertDontSee($product1->name);
    }

    /** @test */
    public function it_filters_by_price()
    {
        $admin = $this->createAdmin();
        $category = $this->createCustomCategory('Altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Altavoces portátiles');
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Altavoz', $subcategory, $brand, '2');
        $product->price = '19.99';
        $product->save();
        $product1 = $this->createProduct();
        $product1->price = '20';
        $product1->save();

        $this->actingAs($admin)->get('/admin/products2?minPrice=9.99&maxPrice=19.99')
            ->assertOk()
            ->assertSee($product->name)
            ->assertSee($product->price)
            ->assertDontSee($product1->name);
    }

    /** @test */
    public function it_filters_by_color()
    {
        $admin = $this->createAdmin();
        $product = $this->createColorProduct();
        $product1 = $this->createProduct();
        $product1->name = 'Móvil LG';
        $product1->save();

        $this->actingAs($admin)->get('/admin/products2?selectedColors[0]=1')
            ->assertOk()
            ->assertSee($product->name)
            ->assertDontSee($product1->name);
    }

    /** @test */
    public function it_searchs_a_size()
    {
        $admin = $this->createAdmin();
        $product = $this->createColorSizeProduct();
        $product1 = $this->createProduct();
        $product1->name = 'Móvil LG';
        $product1->save();

        $this->actingAs($admin)->get('/admin/products2?searchSize=XL')
            ->assertOk()
            ->assertSee($product->name)
            ->assertSee('XL')
            ->assertDontSee($product1->name);
    }

    /** @test */
    public function it_filters_by_status()
    {
        $admin = $this->createAdmin();
        $category = $this->createCustomCategory('Altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Altavoces portátiles');
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Altavoz', $subcategory, $brand, '2');
        $product1 = $this->createProduct();
        $product1->status = 1;
        $product1->save();

        $this->actingAs($admin)->get('/admin/products2?status=2')
            ->assertOk()
            ->assertSee($product->name)
            ->assertSee('Publicado')
            ->assertDontSee($product1->name);
    }

}
