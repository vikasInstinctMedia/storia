<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug', 150)->unique();
            $table->string('sku', 150)->unique();
            $table->unsignedMediumInteger('category_id');
            $table->text('description');
            $table->unsignedDecimal('price', $precision = 10, $scale = 2);
            $table->string('banner_image');
            $table->string('thumbnail_image');
            $table->unsignedMediumInteger('quantity');
            $table->json('nutritional_information');
            $table->softDeletes();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
