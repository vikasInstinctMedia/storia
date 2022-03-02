<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountColumnInProductPackMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_pack_maps', function (Blueprint $table) {
            $table->unsignedDecimal('discount', $precision = 10, $scale = 2)->after('sku');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_pack_maps', function (Blueprint $table) {
            $table->dropColumn('discount');
        });
    }
}
