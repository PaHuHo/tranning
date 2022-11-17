<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MstProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_product', function (Blueprint $table) {
            //$table->id();
            $table->string("product_id",20)->unique()->primary();
            //$table->string("product_id",20)->unique();
            $table->string('product_name',255);
            $table->string('product_image',255)->nullable();
            $table->decimal('product_price')->default(0);
            $table->tinyInteger('is_sales')->default(1)->comment('0 : Dừng bán hoặc dừng sản xuất  , 1: Có hàng bán');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('mst_product');
    }
}
