<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDimentionColumnsToProductPackMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_pack_maps', function (Blueprint $table) {
            $table->unsignedDecimal('length', $precision = 6, $scale = 2)->default(0)->after('discount');
            $table->unsignedDecimal('breadth', $precision = 6, $scale = 2)->default(0)->after('length');
            $table->unsignedDecimal('height', $precision = 6, $scale = 2)->default(0)->after('breadth');
            $table->unsignedInteger('weight')->default(0)->after('height');
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
            $table->dropColumn(['length', 'breadth', 'height', 'weight']);
        });
    }
}
