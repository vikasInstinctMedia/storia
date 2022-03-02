<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePincodesAndCleanProdcutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('branch_deliverable_pincodes', function (Blueprint $table) {
            $table->string('state',50)->after('pincode');
            $table->string('city',50)->after('state');
            $table->boolean('cod_available')->after('city');
            $table->boolean('prepaid_available')->after('cod_available');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('sku');
            $table->dropColumn('category_id');
            $table->dropColumn('quantity');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branch_deliverable_pincodes', function (Blueprint $table) {
            $table->dropColumn('state');
            $table->dropColumn('city');
            $table->dropColumn('cod_available');
            $table->dropColumn('prepaid_available');
        });
    }
}
