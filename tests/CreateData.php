<?php

namespace Tests;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;

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

    public function createCustomSubcategory($id, $name)
    {
        return Subcategory::create([
                'category_id' => $id,
                'name' => $name,
                'slug' => Str::slug($name),
            ]
        );
    }
}