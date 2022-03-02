<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorySliderImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_slider_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categorys_id')->nullable();
            $table->foreign('categorys_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->timestamps();
            $table->bigInteger("created_by")->default(0);
            $table->bigInteger("updated_by")->default(0);
            $table->tinyInteger("status")->default(1)->comment("1. active, 2. inactive");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_slider_images');
    }
}
