<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaymgmtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daymgmts', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('status')->default(0);
            $table->integer('isopen')->default(0);
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
        Schema::dropIfExists('daymgmts');
    }
}
