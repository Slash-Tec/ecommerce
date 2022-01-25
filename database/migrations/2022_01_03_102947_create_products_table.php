<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug');

            $table->text('description');

            $table->float('price');

            $table->foreignId('subcategory_id')->references('id')->on('subcategories');

            $table->foreignId('brand_id')->references('id')->on('brands');

            $table->integer('quantity')->nullable();

            $table->enum('status', [Product::BORRADOR, Product::PUBLICADO])->default(Product::BORRADOR);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
