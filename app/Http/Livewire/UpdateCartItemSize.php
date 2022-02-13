<?php

namespace App\Http\Livewire;

use App\Models\Color;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class UpdateCartItemColor extends Component
{
    public $rowId;
    public $qty, $quantity;
    public function mount()
    {
        $item = Cart::get($this->rowId);
        $this->qty = $item->qty;
        $color = Color::where('name', $item->options->color)->first();
        $this->quantity = qty_available($item->id, $color->id);
    }
    public function decrement()
    {
        $this->qty--;
        Cart::update($this->rowId, $this->qty);
        $this->emit('render');
    }
    public function increment()
    {
        $this->qty++;
        Cart::update($this->rowId, $this->qty);
        $this->emit('render');
    }

    public function render()
    {
        return view('livewire.update-cart-item-color');
    }
}
