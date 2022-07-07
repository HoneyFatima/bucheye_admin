<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('vendor_id');
            $table->integer('order_id');
            $table->integer('address_id');
            $table->integer('coupon_id');
            $table->integer('offer_id');
            $table->integer('order_amount');
            $table->integer('delivery_charge');
            $table->integer('tip_amount');
            $table->string('order_status');
            $table->string('payment_status');
            $table->string('payment_mode');
            $table->string('payment_response');
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
        Schema::dropIfExists('orders');
    }
}
