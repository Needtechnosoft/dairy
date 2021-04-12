<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCounterstatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

    //    Counter_id,date,requested_amt,status,approve_amt,currentstock

        Schema::create('counterstatuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('counter_id');
            $table->foreign('counter_id')->references('id')->on('counters');
            $table->date('date');
            $table->decimal('requested_amount',12,2);
            $table->integer('status');
            $table->decimal('approve_amount',12,2);
            $table->decimal('current_stock',12,2);
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
        Schema::dropIfExists('counterstatuses');
    }
}
