<?php

namespace App\Http\Livewire\Admin;

use App\Models\Size;
use Livewire\Component;

class SizeProduct extends Component
{

    public $product, $name, $size;
    public $open = false;
    public $name_edit;


    protected $listeners = ['delete'];

    protected $rules = [
        'name' => 'required'
    ];

    public function edit(Size $size)
    {
        $this->open = true;
        $this->size = $size;
        $this->name_edit = $size->name;

    }

    public function save()
    {
        $this->validate();

        $size = Size::where('product_id', $this->product->id)
            ->where('name', $this->name)
            ->first();
        if ($size) {
            $this->emit('errorSize', 'Esa talla ya existe');
        } else {
            $this->product->sizes()->create([
                'name' => $this->name
            ]);
        }
        $this->product = $this->product->fresh();
        $this->reset('name');
    }

    public function update()
    {
        $this->validate([
            'name_edit' => 'required',
        ]);
        $this->size->name = $this->name_edit;
        $this->size->save();
        $this->product = $this->product->fresh();
        $this->open = false;
    }

    public function delete(Size $size)
    {
        $size->delete();
        $this->product = $this->product->fresh();
    }

    public function render()
    {
        $sizes = $this->product->sizes;

        return view('livewire.admin.size-product', compact('sizes'));
    }
}
