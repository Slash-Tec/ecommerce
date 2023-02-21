<?php

namespace App\Models;

use App\Filters\QueryFilter;
use App\ProductQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    const BORRADOR = 1;
    const PUBLICADO = 2;


    protected $fillable = ['name', 'slug', 'description', 'price', 'subcategory_id', 'brand_id', 'quantity'];
    //protected $guarded = ['id', 'created_at', 'updated_at'];

    public function sizes()
    {
        return $this->hasMany(Size::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class)->withPivot('quantity', 'id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function getStockAttribute(){
        if ($this->subcategory->size) {
            return ColorSize::whereHas('size.product', function(Builder $query){
                $query->where('id', $this->id);
            })->sum('quantity');
        } elseif ($this->subcategory->color) {
            return ColorProduct::whereHas('product', function(Builder $query){
                $query->where('id', $this->id);
            })->sum('quantity');
        } else {
            return $this->quantity;
        }
    }

    public static function getQuantities()
    {
        $products = Product::with(['colors', 'sizes'])->get();
        foreach ($products as $product) {
            if($product->colors){
            foreach ($product->colors as $color){
                $product->quantity += $color->pivot->quantity;
                foreach ($product->sizes as $size){
                    foreach ($size->colors as $sizeColor)
                    $product->quantity += $sizeColor->pivot->quantity;
                }
            }
            } else{
                return $products;
            }
        }

        return $products;
    }

    public function newEloquentBuilder($query)
    {
        return new ProductQuery($query);
    }

    public function scopeFilterBy($query, QueryFilter $filters, array $data)
    {
        return $filters->applyto($query, $data);
    }
}
