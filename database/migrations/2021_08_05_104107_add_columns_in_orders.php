<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            //

            $table->unsignedBigInteger('billing_address_id')->nullable()->after('payment_status');
            // $table->foreign('billing_address_id')->references('id')->on('addresses')->onDelete('cascade');

            $table->unsignedBigInteger('shipping_address_id')->nullable()->after('billing_address_id');
            // $table->foreign('shipping_address_id')->references('id')->on('addresses')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
