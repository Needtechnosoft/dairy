<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('date');
            $table->integer('bill_no');
            $table->string('transaction_mode');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->decimal('gross_total',12,2)->default(0);
            $table->decimal('net_total',12,2)->default(0);
            $table->decimal('discount',12,2)->default(0);
            $table->decimal('tax',12,2)->default(0);
            $table->decimal('due',12,2)->default(0);
            $table->decimal('paid',12,2)->default(0);
            $table->decimal('taxable_amount',12,2)->default(0);
            $table->integer('status')->default(0);
            $table->unsignedBigInteger('fiscalyear_id');
            $table->foreign('fiscalyear_id')->references('id')->on('fiscalyears');
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
        Schema::dropIfExists('purchase_invoices');
    }
}
