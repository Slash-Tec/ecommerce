<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::whereHas('subcategory', function (Builder $query) {
            $query->where('color', true)->where('size', true);
        })->get();
        $sizes = ['Talla S', 'Talla M', 'Talla L'];
        foreach ($products as $product) {
            foreach ($sizes as $size) {
                $product->sizes()->create(['name' => $size]);
            }
        }
    }
}
