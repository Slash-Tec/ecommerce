<?php

namespace Tests\Feature;

use App\Http\Livewire\Admin\EditProduct;
use App\Http\Livewire\Admin\StatusProduct;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\CreateData;

class EditProductsTest extends TestCase
{
    use RefreshDatabase;
    use CreateData;
    use DatabaseMigrations;

    /** @test */
    public function users_cant_edit_products()
    {
        $user = $this->createUser();
        $product = $this->createProduct();
        $this->actingAs($user)->get('admin/products/' . $product->id .'/edit')
            ->assertForbidden();
    }

    /** @test */
    public function it_loads_the_edition_page_of_a_product()
    {
        $product = $this->createProduct();

        $user = $this->createAdmin();
        $this->actingAs($user)->get('admin/products/' . $product->id .'/edit')
            ->assertOk()
            ->assertSeeLivewire('admin.edit-product');
    }

    /** @test */
    public function it_edits_a_product()
    {
        $product = $this->createProduct();
        $category = $this->createCustomCategory('Tv y audio');
        $subcategory = $this->createCustomSubcategory($category->id,'Tvs');
        $brand = $category->brands()->create(['name' => 'LG']);

        Livewire::test(EditProduct::class, ['product' => $product])
            ->set('category_id', $category->id)
            ->set('product.name', 'TV LG')
            ->set('product.slug', 'tv-lg')
            ->set('product.subcategory_id',$subcategory->id)
            ->set('product.brand_id', $brand->id)
            ->set('product.description','Tv LG',)
            ->set('product.price', '418.99',)
            ->set('product.quantity', '10',)
            ->call('save')
            ->assertSee('Actualizado');
        $this->assertDatabaseHas('products', ['name' => 'TV LG', 'slug' => 'tv-lg',
            'subcategory_id' => $subcategory->id, 'brand_id' => $brand->id,
            'description' => 'Tv LG',
            'price' => '418.99', 'quantity' => 10]);
    }

    /** @test */
    public function it_is_possible_to_change_the_status_of_a_product()
    {
        $product = $this->createProduct();

        Livewire::test(StatusProduct::class, ['product' => $product])
            ->set('status', '1')
            ->call('save');
        $this->assertDatabaseHas('products', ['status' => 1]);
    }

    /** @test */
    public function it_deletes_a_product()
    {

        $product = $this->createProduct();

        Livewire::test(EditProduct::class, ['product' => $product])
            ->call('delete')
        ->assertRedirect('/admin');
        $this->assertEquals(0,Product::count());
    }

    /** @test */
    public function the_category_id_is_required()
    {
        $product = $this->createProduct();
        $category = $this->createCustomCategory('Tv y audio');
        $subcategory = $this->createCustomSubcategory($category->id,'Tvs');
        $brand = $category->brands()->create(['name' => 'LG']);

        Livewire::test(EditProduct::class, ['product' => $product])
            ->set('category_id', '')
            ->set('product.name', 'TV LG')
            ->set('product.slug', 'tv-lg')
            ->set('product.subcategory_id',$subcategory->id)
            ->set('product.brand_id', $brand->id)
            ->set('product.description','Tv LG',)
            ->set('product.price', '418.99',)
            ->set('product.quantity', '20',)
            ->call('save')
            ->assertHasErrors(['category_id']);
        $this->assertDatabaseHas('products', ['name' => $product->name, 'slug' => $product->slug,
            'subcategory_id' => $product->subcategory->id, 'brand_id' => $product->brand->id,
            'description' => $product->description,
            'price' => $product->price, 'quantity' => $product->quantity]);
    }

    /** @test */
    public function the_subcategory_id_is_required()
    {
        $product = $this->createProduct();
        $category = $this->createCustomCategory('Tv y audio');
        $brand = $category->brands()->create(['name' => 'LG']);

        Livewire::test(EditProduct::class, ['product' => $product])
            ->set('category_id', $category->id)
            ->set('product.name', 'TV LG')
            ->set('product.slug', 'tv-lg')
            ->set('product.subcategory_id','')
            ->set('product.brand_id', $brand->id)
            ->set('product.description','Tv LG',)
            ->set('product.price', '418.99',)
            ->set('product.quantity', '20',)
            ->call('save')
            ->assertHasErrors(['product.subcategory_id']);
        $this->assertDatabaseHas('products', ['name' => $product->name, 'slug' => $product->slug,
            'subcategory_id' => $product->subcategory->id, 'brand_id' => $product->brand->id,
            'description' => $product->description,
            'price' => $product->price, 'quantity' => $product->quantity]);
    }

    /** @test */
    public function the_name_is_required()
    {
        $product = $this->createProduct();
        $category = $this->createCustomCategory('Tv y audio');
        $subcategory = $this->createCustomSubcategory($category->id,'Tvs');
        $brand = $category->brands()->create(['name' => 'LG']);

        Livewire::test(EditProduct::class, ['product' => $product])
            ->set('category_id', $category->id)
            ->set('product.name', '')
            ->set('product.slug', 'tv-lg')
            ->set('product.subcategory_id', $subcategory->id)
            ->set('product.brand_id', $brand->id)
            ->set('product.description','Tv LG',)
            ->set('product.price', '418.99',)
            ->set('product.quantity', '20',)
            ->call('save')
            ->assertHasErrors(['product.name']);
        $this->assertDatabaseHas('products', ['name' => $product->name, 'slug' => $product->slug,
            'subcategory_id' => $product->subcategory->id, 'brand_id' => $product->brand->id,
            'description' => $product->description,
            'price' => $product->price, 'quantity' => $product->quantity]);
    }

    /** @test */
    public function the_slug_is_required()
    {
        $product = $this->createProduct();
        $category = $this->createCustomCategory('Tv y audio');
        $subcategory = $this->createCustomSubcategory($category->id,'Tvs');
        $brand = $category->brands()->create(['name' => 'LG']);

        Livewire::test(EditProduct::class, ['product' => $product])
            ->set('category_id', $category->id)
            ->set('product.name', 'TV LG')
            ->set('product.slug', '')
            ->set('product.subcategory_id', $subcategory->id)
            ->set('product.brand_id', $brand->id)
            ->set('product.description','Tv LG',)
            ->set('product.price', '418.99',)
            ->set('product.quantity', '20',)
            ->call('save')
            ->assertHasErrors(['product.slug']);
        $this->assertDatabaseHas('products', ['name' => $product->name, 'slug' => $product->slug,
            'subcategory_id' => $product->subcategory->id, 'brand_id' => $product->brand->id,
            'description' => $product->description,
            'price' => $product->price, 'quantity' => $product->quantity]);
    }

    /** @test */
    public function the_slug_is_unique()
    {
        $this->createProduct();
        $category = $this->createCustomCategory('Tv y audio');
        $subcategory = $this->createCustomSubcategory($category->id, 'Tvs');
        $brand = $category->brands()->create(['name' => 'LG']);
        $product = $this->createCustomProduct('Cascos LG', $subcategory, $brand, '2');


        Livewire::test(EditProduct::class, ['product' => $product])
            ->set('category_id', $category->id)
            ->set('product.name', 'TV LG')
            ->set('product.slug', 'tablet-lg2080')
            ->set('product.subcategory_id', $subcategory->id)
            ->set('product.brand_id', $brand->id)
            ->set('product.description', 'Tv LG',)
            ->set('product.price', '418.99',)
            ->set('product.quantity', '20',)
            ->call('save')
            ->assertHasErrors(['product.slug']);
        $this->assertDatabaseHas('products', ['name' => $product->name, 'slug' => $product->slug,
            'subcategory_id' => $product->subcategory->id, 'brand_id' => $product->brand->id,
            'description' => $product->description,
            'price' => $product->price, 'quantity' => $product->quantity]);
    }

    /** @test */
    public function the_description_is_required()
    {
        $product = $this->createProduct();
        $category = $this->createCustomCategory('Tv y audio');
        $subcategory = $this->createCustomSubcategory($category->id,'Tvs');
        $brand = $category->brands()->create(['name' => 'LG']);

        Livewire::test(EditProduct::class, ['product' => $product])
            ->set('category_id', $category->id)
            ->set('product.name', 'TV LG')
            ->set('product.slug', 'tv-lg')
            ->set('product.subcategory_id', $subcategory->id)
            ->set('product.brand_id', $brand->id)
            ->set('product.description','',)
            ->set('product.price', '418.99',)
            ->set('product.quantity', '20',)
            ->call('save')
            ->assertHasErrors(['product.description']);
        $this->assertDatabaseHas('products', ['name' => $product->name, 'slug' => $product->slug,
            'subcategory_id' => $product->subcategory->id, 'brand_id' => $product->brand->id,
            'description' => $product->description,
            'price' => $product->price, 'quantity' => $product->quantity]);
    }

    /** @test */
    public function the_price_is_required()
    {
        $product = $this->createProduct();
        $category = $this->createCustomCategory('Tv y audio');
        $subcategory = $this->createCustomSubcategory($category->id,'Tvs');
        $brand = $category->brands()->create(['name' => 'LG']);

        Livewire::test(EditProduct::class, ['product' => $product])
            ->set('category_id', $category->id)
            ->set('product.name', 'TV LG')
            ->set('product.slug', 'tv-lg')
            ->set('product.subcategory_id', $subcategory->id)
            ->set('product.brand_id', $brand->id)
            ->set('product.description','Tv LG')
            ->set('product.price', '')
            ->set('product.quantity', '20')
            ->call('save')
            ->assertHasErrors(['product.price']);
        $this->assertDatabaseHas('products', ['name' => $product->name, 'slug' => $product->slug,
            'subcategory_id' => $product->subcategory->id, 'brand_id' => $product->brand->id,
            'description' => $product->description,
            'price' => $product->price, 'quantity' => $product->quantity]);
    }

    /** @test */
    public function the_quantity_is_required()
    {
        $product = $this->createProduct();
        $category = $this->createCustomCategory('Tv y audio');
        $subcategory = $this->createCustomSubcategory($category->id,'Tvs');
        $brand = $category->brands()->create(['name' => 'LG']);

        Livewire::test(EditProduct::class, ['product' => $product])
            ->set('category_id', $category->id)
            ->set('product.name', 'TV LG')
            ->set('product.slug', 'tv-lg')
            ->set('product.subcategory_id', $subcategory->id)
            ->set('product.brand_id', $brand->id)
            ->set('product.description','Tv LG')
            ->set('product.price', '418.99')
            ->set('product.quantity', '')
            ->call('save')
            ->assertHasErrors(['product.quantity']);
        $this->assertDatabaseHas('products', ['name' => $product->name, 'slug' => $product->slug,
            'subcategory_id' => $product->subcategory->id, 'brand_id' => $product->brand->id,
            'description' => $product->description,
            'price' => $product->price, 'quantity' => $product->quantity]);
    }
}
