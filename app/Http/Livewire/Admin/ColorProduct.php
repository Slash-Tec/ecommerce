<?php

namespace App\Http\Livewire\Admin;

use App\Models\Color;
use Livewire\Component;
use App\Models\ColorProduct as TbPivot;

class ColorProduct extends Component
{
    protected $rules = [
        'color_id' => 'required',
        'quantity' => 'required|numeric'
    ];

    protected $listeners = ['delete'];

    public $product, $colors;
    public $color_id, $quantity;
    public $open = false;
    public $pivot, $pivot_color_id, $pivot_quantity;

    public function mount()
    {
        $this->colors = Color::all();
    }

    public function render()
    {
        $productColors = $this->product->colors;

        return view('livewire.admin.color-product', compact('productColors'));
    }

    public function edit(TbPivot $pivot)
    {
        $this->open = true;
        $this->pivot = $pivot;
        $this->pivot_color_id = $pivot->color_id;
        $this->pivot_quantity = $pivot->quantity;
    }

    public function update()
    {
        $this->pivot->color_id = $this->pivot_color_id;
        $this->pivot->quantity = $this->pivot_quantity;
        $this->pivot->save();
        $this->product = $this->product->fresh();
        $this->open = false;
    }

    public function save(){
        $this->validate();
        $pivot = TbPivot::where('color_id', $this->color_id)
            ->where('product_id', $this->product->id)
            ->first();
        if ($pivot) {
            $pivot->quantity += $this->quantity;
            $pivot->save();
        } else {
            $this->product->colors()->attach([
                $this->color_id => [
                    'quantity' => $this->quantity
                ]
            ]);
        }
        $this->reset(['color_id', 'quantity']);
        $this->emit('saved');
        $this->product = $this->product->fresh();
    }

    public function delete(TbPivot $pivot)
    {
        $pivot->delete();
        $this->product = $this->product->fresh();
    }
}
