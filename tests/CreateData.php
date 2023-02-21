<?php

namespace Tests;

use App\Models\Category;
use App\Models\Color;
use App\Models\Image;
use App\Models\Order;
use App\Models\Product;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
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

    public function createOrder()
    {
        $product = $this->createProduct();
        $user = $this->createUser();


        $product->images()->create(['url' => 'storage/324234324323423.png']);
        $order = new Order();
        $order->user_id = $user->id;
        $order->contact = $user->name;
        $order->phone = '42343423234';
        $order->envio_type = '2';
        $order->shipping_cost = 0;
        $order->total = '40';

        $order->content = $product;
        $order->save();

        return $order;
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

    public function createColorSubcategory()
    {
        return Subcategory::create([
                'category_id' => 1,'name' => 'Celulares y smartphones',
                'slug' => Str::slug('Celulares y smartphones'),
                'color' => true
            ]
        );
    }

    public function createColorSizeSubcategory()
    {
        return Subcategory::create([
                'category_id' => 1,'name' => 'Celulares y smartphones',
                'slug' => Str::slug('Celulares y smartphones'),
                'color' => true, 'size'=> true
            ]
        );
    }

    public function createBrand()
    {
        $category = $this->createCategory();
        return $category->brands()->create(['name' => 'LG']);
    }


    public function createUser()
    {
        return User::factory()->create([
            'name' => 'Salvador Céspedes',
            'email' => 'salva@test.com',
            'password' => bcrypt('123'),
        ]);
    }

    public function createAdmin()
    {
        $this->createProduct();

        Role::create(['name' => 'admin']);

        return User::factory()->create([
            'name' => 'Salvador Céspedes',
            'email' => 'salva@test.com',
            'password' => bcrypt('123'),
        ])->assignRole('admin');
    }

    public function createProduct()
    {
        $category = $this->createCategory();

        $subcategory = $this->createSubcategory();

        $brand = $category->brands()->create(['name' => 'LG']);

        $product = Product::factory()->create([
            'name' => 'Tablet LG2080',
            'slug' => Str::slug('Tablet LG2080'),
            'description' => 'Tablet LG2080' . 'moderno año 2022',
            'subcategory_id' => $subcategory->id,
            'brand_id' => $brand->id,
            'price' => '118.99',
            'quantity' => '20',
            'status' => 2
        ]);
       $product->images()->create(['url' => 'storage/324234324323423.png']);

       return $product;
    }

    public function createCustomProduct($name, $subcategory, $brand, $status)
    {
        $product = Product::factory()->create([
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $name . ' moderno año 2022',
            'subcategory_id' => $subcategory->id,
            'brand_id' => $brand->id,
            'price' => '118.99',
            'quantity' => '20',
            'status' => $status
        ]);


        $product->images()->create(['url' => 'storage/324234324323423.png']);

        return $product;
    }

    public function createProducts($products)
    {
        return Product::factory($products)->create()->each(function (Product $product) {
            Image::factory(1)->create(['imageable_id' => $product->id, 'imageable_type' => Product::class]);
        });
    }

    public function createColorProduct()
    {
        $category = $this->createCategory();

        $subcategory = $this->createColorSubcategory();

        $brand = $category->brands()->create(['name' => 'LG']);
        $product = Product::factory()->create([
            'name' => 'Tablet LG2080',
            'slug' => Str::slug('Tablet LG2080'),
            'description' => 'Tablet LG2080' . 'moderno año 2022',
            'subcategory_id' => $subcategory->id,
            'brand_id' => $brand->id,
            'price' => '118.99',
            'quantity' => '20',
            'status' => 2
        ]);

        $product->images()->create(['url' => 'storage/324234324323423.png']);

        Color::create(['name' => 'Blanco']);

        $product->colors()->attach([1 => ['quantity' => 20]]);

        return $product;
    }

    public function createColorSizeProduct()
    {
        $category = $this->createCategory();

        $subcategory = $this->createColorSizeSubcategory();

        $brand = $category->brands()->create(['name' => 'LG']);
        $product = Product::factory()->create([
            'name' => 'Tablet LG2080',
            'slug' => Str::slug('Tablet LG2080'),
            'description' => 'Tablet LG2080' . 'moderno año 2022',
            'subcategory_id' => $subcategory->id,
            'brand_id' => $brand->id,
            'price' => '118.99',
            'quantity' => '20',
            'status' => 2
        ]);
        $product->images()->create(['url' => 'storage/324234324323423.png']);

        Color::create(['name' => 'Blanco']);

        $product->colors()->attach([1 => ['quantity' => 20]]);

        $size = Size::create(['name' => 'XL', 'product_id'=>$product->id]);
        $size->colors()->attach([1 => ['quantity' => 20]]);

        return $product;
    }

    public function createOutStockColorSizeProduct()
    {
        $category = $this->createCategory();

        $subcategory = $this->createColorSizeSubcategory();

        $brand = $category->brands()->create(['name' => 'LG']);
        $product = Product::factory()->create([
            'name' => 'Tablet LG2080',
            'slug' => Str::slug('Tablet LG2080'),
            'description' => 'Tablet LG2080' . 'moderno año 2022',
            'subcategory_id' => $subcategory->id,
            'brand_id' => $brand->id,
            'price' => '118.99',
            'quantity' => 0,
            'status' => 2
        ]);
        $product->images()->create(['url' => 'storage/324234324323423.png']);

        Color::create(['name' => 'Blanco']);

        $product->colors()->attach([1 => ['quantity' => 0]]);

        $size = Size::create(['name' => 'XL', 'product_id'=>$product->id]);
        $size->colors()->attach([1 => ['quantity' => 0]]);

        return $product;
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

    public function products()
    {
        $category = $this->createCategory();

        $subcategory = $this->createSubcategory();

        $brand = $category->brands()->create(['name' => 'LG']);

        return [
            'product1' => $this->createCustomProduct('LG2080', $subcategory, $brand, 2),
        'product2' => $this->createCustomProduct('LGK40', $subcategory, $brand, 2),
        'product3' => $this->createCustomProduct('LGQ60', $subcategory, $brand, 2),
        'product4' => $this->createCustomProduct('LGP40', $subcategory, $brand, 2),
        'product5' => $this->createCustomProduct('LGH90', $subcategory, $brand, 2),
        ];

    }

    public function createOutOfStockColorProduct()
    {
        $category = $this->createCategory();

        $subcategory = $this->createColorSubcategory();

        $brand = $category->brands()->create(['name' => 'LG']);
        $product = Product::factory()->create([
            'name' => 'Tablet LG2080',
            'slug' => Str::slug('Tablet LG2080'),
            'description' => 'Tablet LG2080' . 'moderno año 2022',
            'subcategory_id' => $subcategory->id,
            'brand_id' => $brand->id,
            'price' => '118.99',
            'quantity' => 0,
            'status' => 2
        ]);

        $product->images()->create(['url' => 'storage/324234324323423.png']);

        Color::create(['name' => 'Blanco']);

        $product->colors()->attach([1 => ['quantity' => 0]]);

        return $product;
    }


    public function assertDatabaseEmpty($table, $connection = null)
    {
        $total = $this->getConnection($connection)->table($table)->count();
        $this->assertSame(0, $total, sprintf(
            "Failed asserting the table [%s] is empty. %s %s found",$table, $total, Str::plural('row', $total)
        ));
    }
}
