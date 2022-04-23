<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreatmentsTableAdd2fk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('treatments');
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_patient');
            $table->unsignedBigInteger('fk_procedure'); 
            $table->unsignedBigInteger('fk_status');
            $table->timestamps();

            $table->foreign('fk_patient')->references('id')->on('users');
            $table->foreign('fk_status')->references('id')->on('treatment_stage_status');
            $table->foreign('fk_procedure')->references('id')->on('procedures');
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('treatments');
    }
}
