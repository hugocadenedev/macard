<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->boolean('active')->default(true);
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('slot_id');
            $table->foreign('slot_id')
                ->references('id')
                ->on('slots')
                ->onDelete("cascade");
            $table->unsignedBigInteger('commercial_id')->nullable();
            $table->foreign('commercial_id')
                ->references('id')
                ->on('commercials');
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
        Schema::dropIfExists('bookings');
    }
}
