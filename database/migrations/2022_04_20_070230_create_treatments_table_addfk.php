<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreatmentsTableAddfk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_patient');
            $table->string('procedure'); /*$table->unsignedBigInteger('fk_title'); //reikia imti kaip isorini rakta is procedures lenteles title abieju ID traukt? */
            $table->decimal('cost', 4, 2); /*$table->unsignedBigInteger('fk_cost');//reikia imti kaip isorini rakta is procedures lenteles cost */
            $table->unsignedBigInteger('fk_status');
            $table->timestamps();

            $table->foreign('fk_patient')->references('id')->on('users');
            $table->foreign('fk_status')->references('id')->on('treatment_stage_status');
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
