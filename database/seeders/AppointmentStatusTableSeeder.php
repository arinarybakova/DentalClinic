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
        $count = DB::table('appointment_status')->count();
        if($count == 0) {
            DB::table('appointment_status')->insert([
                ['status' => 'Rezervuota'],
                ['status' => 'Patvirtinta'],
                ['status' => 'Atšaukta']
            ]);
        }
        else {
            //data already there no need to add data
        }
    }
}
