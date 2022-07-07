<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category_id');
            $table->string('slug');
            $table->string('product_type')->default('None');
            $table->string('unit_type');
            $table->string('product_quantity');
            $table->string('unit');
            $table->string('product_family_id');
            $table->longText('product_descreption')->nullable();
            $table->longText('product_sort_descreption')->nullable();
            $table->longText('product_thumbnails')->nullable();
            $table->string('status')->default('Active');
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}
