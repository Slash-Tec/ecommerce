<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

class EditProduct extends Component
{
    protected $listeners = ['refreshProduct', 'delete'];

    protected $rules = [
        'category_id' => 'required',
        'subcategory_id' => 'required',
        'name' => 'required',
        'slug' => 'required|unique:products',
        'description' => 'required',
        'brand_id' => 'required',
        'price' => 'required',
        'product.quantity' => 'numeric',
    ];

    public $product, $categories, $subcategories, $brands;
    public $category_id;

    public function mount(Product $product)
    {
        $this->product = $product;

        $this->categories = Category::all();
        $this->category_id = $product->subcategory->category->id;

        $this->subcategories = Subcategory::where('category_id', $this->category_id)->get();

        $this->brands = Brand::whereHas('categories', function(Builder $query) {
            $query->where('category_id', $this->category_id);
        })->get();
    }

    public function render()
    {
        return view('livewire.admin.edit-product')->layout('layouts.admin');
    }
    public function updatedCategoryId($value)
    {
        $this->subcategories = Subcategory::where('category_id', $value)->get();
        $this->brands = Brand::whereHas('categories', function(Builder $query) use ($value) {
            $query->where('category_id', $value);
        })->get();
        $this->product->subcategory_id = '';
        $this->product->brand_id = '';
    }

    public function updatedProductName($value){
        $this->product->slug = Str::slug($value);
    }
    public function save()
    {
        $this->rules['product.slug'] = 'required|unique:products,slug,' . $this->product->id;
        if ($this->product->subcategory_id) {
            if (!$this->subcategory->color && !$this->subcategory->size) {
                $this->rules['product.quantity'] = 'required|numeric';
            }
        }
        $this->validate();
        $this->product->save();
        $this->emit('saved');
    }
    public function deleteImage(Image $image)
    {
        Storage::disk('public')->delete([$image->url]);
        $image->delete();
        $this->product = $this->product->fresh();
    }
    public function refreshProduct()
    {
        $this->product = $this->product->fresh();
    }
    public function delete(){
        $images = $this->product->images;
        foreach ($images as $image) {
            Storage::disk('public')->delete($image->url);
            $image->delete();
        }
        $this->product->delete();
        return redirect()->route('admin.index');
    }
}
