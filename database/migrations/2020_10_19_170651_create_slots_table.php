<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->integer("available_amount")->default(1);
            $table->unsignedBigInteger('site_id');
            $table->foreign('site_id')
                ->references('id')
                ->on('sites')
                ->onDelete("cascade");
            $table->unsignedBigInteger('car_id');
            $table->foreign('car_id')
                ->references('id')
                ->on('cars')
                ->onDelete("cascade");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slots');
    }
}
