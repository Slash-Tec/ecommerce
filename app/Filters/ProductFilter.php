<?php

namespace App\Filters;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductFilter extends QueryFilter
{

    public function rules(): array
    {
        return [
            'search' => 'filled',
            'from' => 'filled|date_format:d/m/Y',
            'to' => 'filled|date_format:d/m/Y',
            'searchSize' => 'filled',
            'subcategory' => 'exists:subcategories,id',
            'category' => 'exists:categories,id',
            'brand' => 'exists:brands,id',
            'minPrice' => 'filled|numeric',
            'maxPrice' => 'filled|numeric',
            'stock' => 'numeric',
            'selectedColors' => 'array|exists:colors,id',
            'status' => 'in:1,2'
        ];
    }

    public function search($query, $search)
    {
        return $query->where(function($query) use ($search) {
            $query->where('products.name', 'LIKE', "%{$search}%");
    });
    }

    public function searchSize($query, $search)
    {
        return $query->where(function($query) use ($search){
            return $query->whereHas('sizes', function ($query) use ($search) {
                return $query->where('name', 'LIKE', "%{$search}%");
            });
        });
    }

    public function subcategory($query, $subcategory)
    {
        return $query->where('subcategory_id', $subcategory);
    }

    public function category($query, $category)
    {
        return $query->where(function($query) use ($category){
            return $query->whereHas('subcategory', function ($query) use ($category){
                return $query->where('subcategories.category_id', $category);
        });
        });
    }

    public function brand($query, $brand)
    {
        return $query->where('brand_id',$brand);
    }

    public function minPrice($query, $price)
    {
        return $query->where('price', '>=', $price);
    }

    public function maxPrice($query, $price)
    {
        return $query->where('price', '<=', $price);
    }

    public function stock($query, $stock)
    {
        return $query->where('quantity', '>=', $stock);
    }

    public function status($query, $status)
    {
        return $query->where('status',  $status);
    }


    public function selectedColors($query, $selectedColors)
    {
        $subquery = DB::table('color_product AS s')
            ->selectRaw('COUNT(s.id)')
            ->whereColumn('s.product_id', 'products.id')
            ->whereIn('color_id', $selectedColors);

        $query->addBinding($subquery->getBindings());

        $query->where(DB::raw("({$subquery->toSql()})"), count($selectedColors));
    }

    public function from($query, $date)
    {
        $date = Carbon::createFromFormat('d/m/Y', $date);

        $query->whereDate('products.created_at', '>=', $date);
    }

    public function to($query, $date)
    {
        $date = Carbon::createFromFormat('d/m/Y', $date);

        $query->whereDate('products.created_at', '<=', $date);
    }
}
