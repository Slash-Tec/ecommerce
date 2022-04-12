<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class CreateProduct extends Component
{
    protected $rules = [
        'category_id' => 'required',
        'subcategory_id' => 'required',
        'name' => 'required',
        'slug' => 'required|unique:products',
        'description' => 'required',
        'brand_id' => 'required',
        'price' => 'required',
    ];

    public $categories, $subcategories = [], $brands = [];
    public $category_id = '' , $subcategory_id = '', $brand_id = '';
    public $name, $slug, $description, $price, $quantity;

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function updatedCategoryId($value)
    {
        $this->subcategories = Subcategory::where('category_id', $value)->get();
        
        $this->brands = Brand::whereHas('categories', function(Builder $query) use ($value) {
            $query->where('category_id', $value);
        })->get();

        $this->reset(['subcategory_id', 'brand_id']);
    }
    public function getSubcategoryProperty()
    {
        return Subcategory::find($this->subcategory_id);
    }

    public function render()
    {
        return view('livewire.admin.create-product')->layout('layouts.admin');
    }
    public function updatedName($value){
        $this->slug = Str::slug($value);
    }
    public function save()
    {
        if ($this->subcategory_id && !$this->subcategory->color && !$this->subcategory->size) {
            $this->rules['quantity'] = 'required';
        }

        $this->validate();
    }
    $product = new Product();
    $product->name = $this->name;
    $product->slug = $this->slug;
    $product->description = $this->description;
    $product->price = $this->price;
    $product->subcategory_id = $this->subcategory_id;
    $product->brand_id = $this->brand_id;
    if ($this->subcategory_id && !$this->subcategory->color && !$this->subcategory->size) {
        $product->quantity = $this->quantity;
    }
    $product->save();
}
