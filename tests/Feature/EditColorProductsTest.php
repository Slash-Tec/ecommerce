<?php

namespace Tests\Feature;

use App\Http\Livewire\Admin\ColorProduct;
use App\Models\Color;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\CreateData;

class EditColorProductsTest extends TestCase
{

    use DatabaseMigrations;
    use RefreshDatabase;
    use CreateData;

    /** @test */
    public function it_creates_a_color_product()
    {
        $product = $this->createProduct();
        $color = Color::create(['name' => 'Amarillo']);
        Livewire::test(ColorProduct::class, ['product' => $product])
            ->set('color_id', $color->id)
            ->set('quantity', '2')
            ->call('save');
        $this->assertDatabaseHas('colors', ['name' => $color->name]);
        $this->assertDatabaseHas('color_product', ['color_id' => $color->id, 'product_id' => $product->id, 'quantity' => 2]);
    }

    /** @test */
    public function the_quantity_is_required()
    {
        $product = $this->createProduct();
        Color::create(['name' => 'Blanco']);
        Livewire::test(ColorProduct::class, ['product' => $product])
            ->set('color_id', '1')
            ->set('quantity', '')
            ->call('save')
            ->assertHasErrors(['quantity']);
        $this->assertDatabaseEmpty('color_product');
    }

    /** @test */
    public function the_color_id_is_required()
    {
        $product = $this->createProduct();
        Color::create(['name' => 'Blanco']);
        Livewire::test(ColorProduct::class, ['product' => $product])
            ->set('color_id', '')
            ->set('quantity', '2')
            ->call('save')
            ->assertHasErrors(['color_id']);
        $this->assertDatabaseEmpty('color_product');
    }
}
