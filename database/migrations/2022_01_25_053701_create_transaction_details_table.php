<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->integer('trans_id');
            $table->string('current_amount');
            $table->string('trans_amount');
            $table->string('payment_id');
            $table->string('payment_status');
            $table->string('contact');
            $table->string('method');
            $table->string('bank');
            $table->string('vpa');
            $table->longText('payment_response');
            $table->string('trans_type');
            $table->string('trans_date');
            $table->text('trans_remarks');
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
        Schema::dropIfExists('transaction_details');
    }
}
