<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Navigation extends Component
{
    public function render()
    {
        $categories = Category::all();
        
        return view('livewire.navigation', compact('categories'));
    }
}
