<?php

namespace Tests\Feature;

use App\Http\Livewire\CartMovil;
use App\Http\Livewire\DropdownCart;
use App\Http\Livewire\Navigation;
use App\Http\Livewire\Search;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\CreateData;

class NavTest extends TestCase
{

    use RefreshDatabase;
    use DatabaseMigrations;
    use CreateData;

    /** @test */
    public function it_loads_the_nav_bar()
    {
        $this->createCategory();
        $this->get('/')
            ->assertSeeLivewire('search')
            ->assertSeeLivewire('dropdown-cart')
            ->assertSeeLivewire('navigation');
        Livewire::test(Navigation::class)->assertStatus(200)
        ->assertSee('Categorías')
        ->assertViewHas('categories');

    }

    /** @test */
    public function it_lists_the_categories()
    {
        $category1 = $this->createCategory();

        $category2 = $this->createCustomCategory("TV, audio y video");

        Livewire::test(Navigation::class)
            ->assertStatus(200)
            ->assertSee($category1->name)
            ->assertSee($category2->name);
    }
    /** @test */
    public function it_loads_the_search_input()
    {
        Livewire::test(Search::class)
            ->assertStatus(200)
            ->assertSee('¿Estás buscando algún producto?');
    }

    /** @test */
    public function it_loads_the_dropdown_cart()
    {
        Livewire::test(DropdownCart::class)
            ->assertStatus(200)
            ->assertSee('No tiene agregado ningún item en el carrito');
    }

    /** @test */
    public function it_loads_the_dropdown_cart_responsive()
    {
        Livewire::test(CartMovil::class)
            ->assertStatus(200)
            ->assertSee('Carrito de compras');
    }
}
