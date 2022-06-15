<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subcategories = [/* Celulares y tablets */[
            'category_id' => 1,'name' => 'Celulares y smartphones',
            'slug' => Str::slug('Celulares y smartphones'),
            'color' => true],['category_id' => 1,
            'name' => 'Accesorios para celulares',
            'slug' => Str::slug('Accesorios para celulares'),
            ],
            ['category_id' => 1,
                'name' => 'Smartwatches',
                'slug' => Str::slug('Smartwatches'),
                ],
            /* TV, audio y video */
            ['category_id' => 2,'name' => 'TV y audio',
                'slug' => Str::slug('TV y audio'),
                ],
            ['category_id' => 2,
                'name' => 'Audios',
                'slug' => Str::slug('Audios'),
                ],
            ['category_id' => 2,
                'name' => 'Audio para autos',
                'slug' => Str::slug('Audio para autos'),
                ],
            /* Consola y videojuegos */
            ['category_id' => 3,
                'name' => 'Xbox',
                'slug' => Str::slug('xbox'),
                ],
            ['category_id' => 3,
                'name' => 'Play Station',
                'slug' => Str::slug('Play Station'),
                ],
            ['category_id' => 3,
                'name' => 'Videojuegos para PC',
                'slug' => Str::slug('Videojuegos para PC'),
                ],
            ['category_id' => 3,
                'name' => 'Nintendo',
                'slug' => Str::slug('Nintendo'),
                ],
            /* Merchandising */
            ['category_id' => 4,
                'name' => 'Anime',
                'slug' => Str::slug('Anime'),
                ],
            ['category_id' => 4,
                'name' => 'Videojuegos',
                'slug' => Str::slug('Videojuegos'),
                ],
            ['category_id' => 4,
                'name' => 'Series',
                'slug' => Str::slug('Series'),
                ],
            ['category_id' => 4,
                'name' => 'Dibujos animados',
                'slug' => Str::slug('Dibujos animados'),
                ],
            /* Computación */
            ['category_id' => 5,
                'name' => 'Portátiles',
                'slug' => Str::slug('Portátiles'),
                ],
            ['category_id' =>5,'name' => 'PC escritorio',
                'slug' => Str::slug('PC escritorio'),
                ],
            ['category_id' => 5,
                'name' => 'Almacenamiento',
                'slug' => Str::slug('Almacenamiento'),
                ],
            ['category_id' => 5,
                'name' => 'Accesorios computadoras',
                'slug' => Str::slug('Accesorios computadoras'),
                ],
            /* Moda */
            ['category_id' => 6,
                'name' => 'Mujeres',
                'slug' => Str::slug('Mujeres'),
                'color' => true,'size' => true],
            ['category_id' => 6,
                'name' => 'Hombres',
                'slug' => Str::slug('Hombres'),
                'color' => true,'size' => true],
            ['category_id' => 6,
                'name' => 'Lentes',
                'slug' => Str::slug('Lentes'),
                ],
            ['category_id' => 6,
                'name' => 'Relojes',
                'slug' => Str::slug('Relojes'),
                ],
            ];
        foreach ($subcategories as $subcategory) {
            Subcategory::create($subcategory);
        }
    }
}
