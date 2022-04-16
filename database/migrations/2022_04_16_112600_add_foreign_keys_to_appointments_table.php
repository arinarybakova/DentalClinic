<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->renameColumn('patient', 'fk_patient');
            $table->renameColumn('dentist', 'fk_dentist');
            $table->unsignedBigInteger('fk_patient')->change();
            $table->unsignedBigInteger('fk_dentist')->change();
            $table->dateTime('time_from');
            $table->dateTime('time_to');
            $table->dropColumn('date');
            $table->dropColumn('time');

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
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('time_from');
            $table->dropColumn('time_to');
            $table->string('date');
            $table->string('time');

            $table->dropForeign('fk_patient');
            $table->dropColumn('fk_dentist');

            $table->string('fk_patient')->change();
            $table->string('fk_dentist')->change();
            $table->renameColumn('fk_patient', 'patient');
            $table->renameColumn('fk_dentist', 'dentist');
        });
    }
}
