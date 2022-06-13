<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class Search extends Component
{

    public $search;
    public $open = false;

    public function updatedSearch($value)
    {
        $value ? $this->open = true : $this->open = false;
    }

    public function render()
    {
        $products = $this->search
            ? Product::where('name', 'LIKE', "%{$this->search}%")->where('status', 2)->take(8)->get()
            : [];
        return view('livewire.search', compact('products'));
    }
}
