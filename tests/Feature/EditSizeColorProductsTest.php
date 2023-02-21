<?php

namespace Tests\Feature;

use App\Http\Livewire\Admin\ColorProduct;
use App\Http\Livewire\Admin\ColorSize;
use App\Http\Livewire\Admin\SizeProduct;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\CreateData;

class EditSizeColorProductsTest extends TestCase
{

    use DatabaseMigrations;
    use RefreshDatabase;
    use CreateData;

    /** @test */
    public function it_creates_a_size_color_product()
    {
        $product = $this->createProduct();

        Livewire::test(SizeProduct::class, ['product' => $product])
           ->set('name', 'Talla XS')
            ->call('save');
        $this->assertDatabaseHas('sizes', ['name' => 'Talla XS', 'product_id' => $product->id]);
    }

    /** @test */
    public function the_name_is_required()
    {
        $product = $this->createProduct();

        Livewire::test(SizeProduct::class, ['product' => $product])
            ->set('name', '')
            ->call('save')
        ->assertHasErrors('name');
        $this->assertDatabaseEmpty('sizes');
    }

    /** @test */
    public function it_adds_a_color_to_a_size()
    {
        $product = $this->createProduct();
        Color::create(['name' => 'Blanco']);
        $size = Size::create(['name' => 'XL', 'product_id'=>$product->id]);
        Livewire::test(ColorSize::class, ['product' => $product, 'size' => $size])
            ->set('color_id', '1')
            ->set('quantity', '2')
            ->call('save');
        $this->assertDatabaseHas('color_size', ['color_id' => 1, 'quantity' => 2]);
    }
}
