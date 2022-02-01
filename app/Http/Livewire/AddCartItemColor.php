<?php

namespace App\Http\Livewire;

use App\Models\Size;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class AddCartItemColor extends Component
{
    public $product;
    public $colors;
    public $qty = 1;
    public $quantity = 0;
    public $color_id = '';
    public $options = [];

    public function mount()
    {
        $this->colors = $this->product->colors;
        $this->options['image'] = Storage::url($this->product->images->first()->url);
    }
    public function updatedColorId($value)
    {
        $color = $this->product->colors->find($value);
        $this->quantity = $color->pivot->quantity;
        $this->options['color'] = $color->name;
    }
    public function decrement()
    {
        $this->qty--;
    }
    public function increment()
    {
       $this->qty++;
    }
    public function addItem()
    {
        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'qty' => $this->qty,
            'price' => $this->product->price,
            'weight' => 550,
            'options' => $this->options,
        ]);
        $this->emitTo('dropdown-cart', 'render');
    }
    public function render()
    {
        return view('livewire.add-cart-item-color');
    }
}
