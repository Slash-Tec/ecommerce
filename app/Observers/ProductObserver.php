<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function updated(Product $product)
    {
        $subcategory = $product->subcategory;
        if ($subcategory->size) {
            $product->colors()->detach();
        } elseif ($subcategory->color) {
            foreach ($product->sizes as $size) {
                $size->delete();
            }
        } else {
            $product->colors()->detach();
            foreach ($product->sizes as $size) {
                $size->delete();
            }
        }
    }
}
