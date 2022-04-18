<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AppointmentStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('appointment_status')->insert([
            ['status' => 'Rezervuota'],
            ['status' => 'Patvirtinta'],
            ['status' => 'Atšaukta']
        ]);
    }
}
