<?php

namespace Tests;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

trait CreateData
{

    public function withData(array $custom = [])
    {
        return array_merge($this->defaultData(), $custom);
    }

    protected function defaultData()
    {
        return $this->defaultData;
    }

    public function createCategory()
    {
        return Category::factory()->create(['name' => 'Celulares y tablets',
            'slug' => Str::slug('Celulares y tablets'),
            'icon' => '<i class="fas fa-mobile-alt"></i>']);
    }

    public function createCustomCategory($name)
    {
        return Category::factory()->create(['name' => $name,
            'slug' => Str::slug($name),
            'icon' => '<i class="fas fa-mobile-alt"></i>']);
    }


    public function createSubcategory()
    {
        return Subcategory::create([
                'category_id' => 1,'name' => 'Celulares y smartphones',
                'slug' => Str::slug('Celulares y smartphones'),
            ]
        );
    }

    public function createBrand()
    {
        $category = $this->createCategory();
        return $category->brands()->create(['name' => 'LG']);
    }

    public function createCategories()
    {
        return [
            'category1' => $this->createCategory(),
        'category2' => $this->createCustomCategory('TV, audio y video'),
        'category3' => $this->createCustomCategory('Consola y videojuegos'),
        'category4' => $this->createCustomCategory('Computación'),
        'category5' => $this->createCustomCategory('Moda'),
        ];
    }
}