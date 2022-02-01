<?php

namespace App\Http\Livewire;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class AddCartItem extends Component
{
    public $product;
    public $quantity;
    public $qty = 1;

    public function mount()
    {
        $this->quantity = $this->product->quantity;
    }

    public function decrement()
    {
        $this->qty--;
    }
    public function increment()
    {
        $this->qty++;
    }

    public function render()
    {
        return view('livewire.add-cart-item');
    }
    public function addItem()
    {
        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'qty' => $this->qty,
            'price' => $this->product->price,
            'weight' => 550,
        ]);
        $this->emitTo('dropdown-cart', 'render');
    }
}
