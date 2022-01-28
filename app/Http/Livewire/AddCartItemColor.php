<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddCartItemColor extends Component
{   
    public $product;
    public $colors;
    public $qty = 1;
    public $quantity = 0;
    public $color_id = '';
    public function mount()
    {
        $this->colors = $this->product->colors;
    }
    public function render()
    {
        return view('livewire.add-cart-item-color');
    }
    public function updatedColorId($value)
    {
       $this->quantity = $this->product->colors->find($value)->pivot->quantity;
    }
    public function decrement()
    {
        $this->qty--;
    }
    public function increment()
    {
       $this->qty++;
    }
}
