<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTableFixed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_patient');
            $table->unsignedBigInteger('fk_dentist');
            $table->dateTime('time_from');
            $table->dateTime('time_to');
            $table->string('status');
            $table->timestamps();

            $table->foreign('fk_patient')->references('id')->on('users');
            $table->foreign('fk_dentist')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
