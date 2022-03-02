<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscription_types_id')->nullable();
            $table->foreign('subscription_types_id')->references('id')->on('subscription_types')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->unsignedBigInteger('categorys_id')->nullable();
            $table->foreign('categorys_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('price')->nullable();
            $table->unsignedBigInteger('packs_id')->nullable();
            $table->foreign('packs_id')->references('id')->on('packs')->onDelete('cascade');
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
        Schema::dropIfExists('subscription');
    }
}
