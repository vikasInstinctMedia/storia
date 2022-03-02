<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesLibrary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images_library', function (Blueprint $table) {
            $table->id();
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
        Schema::dropIfExists('images_library');
    }
}
