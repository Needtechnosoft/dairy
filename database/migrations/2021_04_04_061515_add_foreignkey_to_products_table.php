<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignkeyToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('product_cat_id');
            $table->foreign('product_cat_id')->references('id')->on('product_cats');
            $table->decimal('selling_price',12,2)->default(0);
            $table->decimal('cost_price',12,2)->default(0);
            $table->decimal('sale_price',12,2)->default(0);
            $table->decimal('wholesale_rate',12,2)->default(0);
            $table->string('barcode')->nullable();
            $table->integer('status')->default(0);
            $table->integer('maxqty')->default(0);
            $table->string('sku')->nullable();
            $table->integer('alertqty')->default(5);
            $table->integer('expire_alert')->default(10);
            $table->integer('onsale')->default(0);
            $table->integer('discount_type')->default(0);
            $table->decimal('discount_percentage')->default(0);
            $table->decimal('tax',8,2)->default(0);
            $table->integer('batch_type')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('product_cat_id');
            $table->dropColumn('selling_price',12,2)->default(0);
            $table->dropColumn('cost_price',12,2)->default(0);
            $table->dropColumn('sale_price',12,2)->default(0);
            $table->dropColumn('wholesale_rate',12,2)->default(0);
            $table->dropColumn('barcode')->nullable();
            $table->dropColumn('status')->default(0);
            $table->dropColumn('maxqty')->default(0);
            $table->dropColumn('sku')->nullable();
            $table->dropColumn('alertqty')->default(5);
            $table->dropColumn('expire_date');
        });
    }
}
