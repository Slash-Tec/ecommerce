<?php

namespace Tests\Feature;

use App\Http\Livewire\AddCartItem;
use App\Http\Livewire\AddCartItemColor;
use App\Http\Livewire\AddCartItemSize;
use App\Http\Livewire\CreateOrder;
use App\Models\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\CreateData;

class DbTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;
    use CreateData;


    /** @test */
    public function it_saves_the_shopping_cart_when_user_logs_out()
    {
        $user = $this->createUser();
        $product = $this->createProduct();

        $this->get('/login')->assertSee('Correo electrónico');
        $credentials = [
            "email" => $user->email,
            "password" => '123'
        ];

        $response = $this->post('/login', $credentials);
        $response->assertRedirect('/dashboard');
        $this->assertCredentials($credentials);

        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => '1',
            'price' => $product->price,
            'weight' => 550,
        ]);

        $category = $this->createCategory();
        $subcategory = $this->createSubcategory();
        $brand = $category->brands()->create(['name' => 'LG']);
        $product1 = $this->createCustomProduct('Cascos', $subcategory, $brand, '2');
        Cart::add([
            'id' => $product1->id,
            'name' => $product1->name,
            'qty' => '2',
            'price' => $product1->price,
            'weight' => 550,
        ]);

        Auth::logout();

        $this->assertDatabaseHas('shoppingcart', ['identifier' => $user->id]);

        $this->get('/login')->assertSee('Correo electrónico');

        $this->post('/login', $credentials);

        $this->get('/shopping-cart')->assertSee($product->name)->assertSee($product1->name)
            ->assertSee($product->price)
        ->assertSee($product1->price*2)
        ->assertSee(1)
        ->assertSee(2);


    }

    /** @test */
    public function the_stock_changes_when_creating_an_order(){

        $user = $this->createUser();
        $product = $this->createProduct();
        $this->actingAs($user);
        Livewire::test(AddCartItem::class, ['product' => $product, 'qty' => 2])
            ->call('addItem', $product);

        Livewire::test(CreateOrder::class, [
            'envio_type' => 1,
            'contact' => 'Salva',
            'phone' => '42423424'
        ])
            ->assertSee($product->name)
            ->call('create_order');

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'envio_type' => 1,
            'contact' => 'Salva',
            'phone' => '42423424'
        ]);

        $this->assertDatabaseHas('products', [
            'quantity' => $product->quantity - 2
        ]);
    }

    /** @test */
    public function the_stock_changes_when_creating_an_order_including_color_size_product(){

        $user = $this->createUser();
        $product = $this->createColorSizeProduct();
        $this->actingAs($user);
        Livewire::test(AddCartItemSize::class, ['product' => $product])
            ->set('options', ['size_id' => $product->sizes()->first()->id, 'color_id' => $product->colors()->first()->id])
            ->call('addItem', $product);

        Livewire::test(CreateOrder::class, [
            'envio_type' => 1,
            'contact' => 'Salva',
            'phone' => '42423424'
        ])
            ->assertSee($product->name)
            ->call('create_order');

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'envio_type' => 1,
            'contact' => 'Salva',
            'phone' => '42423424'
        ]);

        $this->assertDatabaseHas('color_size', [
            'color_id' => $product->colors()->first()->id,
            'size_id' => $product->sizes()->first()->id,
            'quantity' => $product->quantity - 1
        ]);
    }

    /** @test */
    public function the_stock_changes_when_creating_an_order_including_color_product(){

        $user = $this->createUser();
        $product = $this->createColorProduct();
        $this->actingAs($user);
        Livewire::test(AddCartItemColor::class, ['product' => $product, 'qty' => 3])
            ->set('options', ['color_id' => $product->colors()->first()->id])
            ->call('addItem', $product);

        Livewire::test(CreateOrder::class, [
            'envio_type' => 1,
            'contact' => 'Salva',
            'phone' => '42423424'
        ])
            ->assertSee($product->name)
            ->call('create_order');

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'envio_type' => 1,
            'contact' => 'Salva',
            'phone' => '42423424'
        ]);

        $this->assertDatabaseHas('color_product', [
            'color_id' => $product->colors()->first()->id,
            'quantity' => $product->quantity - 3
        ]);

    }
}
