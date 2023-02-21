<?php

namespace Tests\Feature;

use App\Models\Color;
use App\Models\Size;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\CreateData;

class SortTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    use CreateData;

    /** @test */
    public function it_orders_by_id_asc()
    {
        $admin = $this->createAdmin();
        $category = $this->createCategory();
        $subcategory = $this->createSubcategory();
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Cascos', $subcategory, $brand, '2');
        $product1 = $this->createProduct();

        $this->actingAs($admin)->get('/admin/products2?sortColumn=id&sortDirection=asc')
            ->assertOk()
            ->assertSeeInOrder([$product->name,$product1->name]);
    }

    /** @test */
    public function it_orders_by_id_desc()
    {
        $admin = $this->createAdmin();
        $category = $this->createCategory();
        $subcategory = $this->createSubcategory();
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Cascos', $subcategory, $brand, '2');
        $product1 = $this->createProduct();

        $this->actingAs($admin)->get('/admin/products2?sortColumn=id&sortDirection=desc')
            ->assertOk()
            ->assertSeeInOrder([$product1->name,$product->name]);
    }

    /** @test */
    public function it_orders_by_name_asc()
    {
        $admin = $this->createAdmin();
        $category = $this->createCategory();
        $subcategory = $this->createSubcategory();
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Cascos', $subcategory, $brand, '2');
        $product1 = $this->createProduct();

        $this->actingAs($admin)->get('/admin/products2?sortColumn=name&sortDirection=asc')
            ->assertOk()
            ->assertSeeInOrder([$product->name,$product1->name]);
    }

    /** @test */
    public function it_orders_by_name_desc()
    {
        $admin = $this->createAdmin();
        $category = $this->createCategory();
        $subcategory = $this->createSubcategory();
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Cascos', $subcategory, $brand, '2');
        $product1 = $this->createProduct();

        $this->actingAs($admin)->get('/admin/products2?sortColumn=name&sortDirection=desc')
            ->assertOk()
            ->assertSeeInOrder([$product1->name,$product->name]);
    }

    /** @test */
    public function it_orders_by_slug_asc()
    {
        $admin = $this->createAdmin();
        $category = $this->createCategory();
        $subcategory = $this->createSubcategory();
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Cascos', $subcategory, $brand, '2');
        $product1 = $this->createProduct();

        $this->actingAs($admin)->get('/admin/products2?sortColumn=slug&sortDirection=asc')
            ->assertOk()
            ->assertSeeInOrder([$product->name,$product1->name]);
    }

    /** @test */
    public function it_orders_by_slug_desc()
    {
        $admin = $this->createAdmin();
        $category = $this->createCategory();
        $subcategory = $this->createSubcategory();
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Cascos', $subcategory, $brand, '2');
        $product1 = $this->createProduct();

        $this->actingAs($admin)->get('/admin/products2?sortColumn=slug&sortDirection=desc')
            ->assertOk()
            ->assertSeeInOrder([$product1->name,$product->name]);
    }

    /** @test */
    public function it_orders_by_description_asc()
    {
        $admin = $this->createAdmin();
        $category = $this->createCategory();
        $subcategory = $this->createSubcategory();
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Cascos', $subcategory, $brand, '2');
        $product1 = $this->createProduct();

        $this->actingAs($admin)->get('/admin/products2?sortColumn=description&sortDirection=asc')
            ->assertOk()
            ->assertSeeInOrder([$product->name,$product1->name]);
    }

    /** @test */
    public function it_orders_by_description_desc()
    {
        $admin = $this->createAdmin();
        $category = $this->createCategory();
        $subcategory = $this->createSubcategory();
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Cascos', $subcategory, $brand, '2');
        $product1 = $this->createProduct();

        $this->actingAs($admin)->get('/admin/products2?sortColumn=description&sortDirection=desc')
            ->assertOk()
            ->assertSeeInOrder([$product1->name,$product->name]);
    }

    /** @test */
    public function it_orders_by_category_asc()
    {
        $admin = $this->createAdmin();
        $product1 = $this->createProduct();
        $category = $this->createCustomCategory('Audio y altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Audio');
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Cascos', $subcategory, $brand, '2');


        $this->actingAs($admin)->get('/admin/products2?sortColumn=categories.name&sortDirection=asc')
            ->assertOk()
            ->assertSeeInOrder([$product->name,$product1->name]);
    }

    /** @test */
    public function it_orders_by_category_desc()
    {
        $admin = $this->createAdmin();
        $product1 = $this->createProduct();
        $category = $this->createCustomCategory('Audio y altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Audio');
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Cascos', $subcategory, $brand, '2');


        $this->actingAs($admin)->get('/admin/products2?sortColumn=categories.name&sortDirection=desc')
            ->assertOk()
            ->assertSeeInOrder([$product1->name,$product->name]);
    }
    /** @test */
    public function it_orders_by_subcategory_asc()
    {
        $admin = $this->createAdmin();
        $product1 = $this->createProduct();
        $category = $this->createCustomCategory('Audio y altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Audio');
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Cascos', $subcategory, $brand, '2');


        $this->actingAs($admin)->get('/admin/products2?sortColumn=subcategories.name&sortDirection=asc')
            ->assertOk()
            ->assertSeeInOrder([$product->name,$product1->name]);
    }

    /** @test */
    public function it_orders_by_subcategory_desc()
    {
        $admin = $this->createAdmin();
        $product1 = $this->createProduct();
        $category = $this->createCustomCategory('Audio y altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Audio');
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Cascos', $subcategory, $brand, '2');


        $this->actingAs($admin)->get('/admin/products2?sortColumn=subcategories.name&sortDirection=desc')
            ->assertOk()
            ->assertSeeInOrder([$product1->name,$product->name]);
    }

    /** @test */
    public function it_orders_by_status_asc()
    {
        $admin = $this->createAdmin();
        $product1 = $this->createProduct();
        $category = $this->createCustomCategory('Audio y altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Audio');
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Cascos', $subcategory, $brand, 1);


        $this->actingAs($admin)->get('/admin/products2?sortColumn=status&sortDirection=asc')
            ->assertOk()
            ->assertSeeInOrder([$product->name,$product1->name]);
    }

    /** @test */
    public function it_orders_by_status_desc()
    {
        $admin = $this->createAdmin();
        $product1 = $this->createProduct();
        $category = $this->createCustomCategory('Audio y altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Audio');
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Cascos', $subcategory, $brand, 1);


        $this->actingAs($admin)->get('/admin/products2?sortColumn=status&sortDirection=desc')
            ->assertOk()
            ->assertSeeInOrder([$product1->name,$product->name]);
    }

    /** @test */
    public function it_orders_by_price_asc()
    {
        $admin = $this->createAdmin();
        $product1 = $this->createProduct();
        $product1->price = 500;
        $product1->save();
        $category = $this->createCustomCategory('Audio y altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Audio');
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Cascos', $subcategory, $brand, 1);


        $this->actingAs($admin)->get('/admin/products2?sortColumn=price&sortDirection=asc')
            ->assertOk()
            ->assertSeeInOrder([$product->name,$product1->name]);
    }

    /** @test */
    public function it_orders_by_price_desc()
    {
        $admin = $this->createAdmin();
        $product1 = $this->createProduct();
        $product1->price = 500;
        $product1->save();
        $category = $this->createCustomCategory('Audio y altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Audio');
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Cascos', $subcategory, $brand, 1);

        $this->actingAs($admin)->get('/admin/products2?sortColumn=price&sortDirection=desc')
            ->assertOk()
            ->assertSeeInOrder([$product1->name,$product->name]);
    }

    /** @test */
    public function it_orders_by_brand_asc()
    {
        $admin = $this->createAdmin();
        $product1 = $this->createProduct();
        $product1->price = 500;
        $product1->save();
        $category = $this->createCustomCategory('Audio y altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Audio');
        $brand = $category->brands()->create(['name' => 'Apple']);
        $product = $this->createCustomProduct('Cascos', $subcategory, $brand, 1);


        $this->actingAs($admin)->get('/admin/products2?sortColumn=brands.name&sortDirection=asc')
            ->assertOk()
            ->assertSeeInOrder([$product->name,$product1->name]);
    }

    /** @test */
    public function it_orders_by_brand_desc()
    {
        $admin = $this->createAdmin();
        $product1 = $this->createProduct();
        $product1->price = 500;
        $product1->save();
        $category = $this->createCustomCategory('Audio y altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Audio');
        $brand = $category->brands()->create(['name' => 'Apple']);
        $product = $this->createCustomProduct('Cascos', $subcategory, $brand, 1);

        $this->actingAs($admin)->get('/admin/products2?sortColumn=brands.name&sortDirection=desc')
            ->assertOk()
            ->assertSeeInOrder([$product1->name,$product->name]);
    }

    /** @test */
    public function it_orders_by_created_at_asc()
    {
        $admin = $this->createAdmin();
        $product1 = $this->createProduct();
        $product1->created_at = '2022-03-06';
        $product1->save();
        $category = $this->createCustomCategory('Audio y altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Audio');
        $brand = $category->brands()->create(['name' => 'Apple']);
        $product = $this->createCustomProduct('Cascos', $subcategory, $brand, 1);


        $this->actingAs($admin)->get('/admin/products2?sortColumn=created_at&sortDirection=asc')
            ->assertOk()
            ->assertSeeInOrder([$product->name,$product1->name]);
    }

    /** @test */
    public function it_orders_by_created_at_desc()
    {
        $admin = $this->createAdmin();
        $product1 = $this->createProduct();
        $product1->created_at = '2022-03-06';
        $product1->save();
        $category = $this->createCustomCategory('Audio y altavoces');
        $subcategory = $this->createCustomSubcategory($category->id, 'Audio');
        $brand = $category->brands()->create(['name' => 'Apple']);
        $product = $this->createCustomProduct('Cascos', $subcategory, $brand, 1);

        $this->actingAs($admin)->get('/admin/products2?sortColumn=created_at&sortDirection=desc')
            ->assertOk()
            ->assertSeeInOrder([$product1->name,$product->name]);
    }
}
