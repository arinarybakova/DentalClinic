<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TreatmentStageStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table('treatment_stage_status')->count();
        if($count == 0) {
            DB::table('treatment_stage_status')->insert([
                ['status' => 'Laukiama'],
                ['status' => 'Atlikta'],
                ['status' => 'Atšaukta']
            ]);
        }
        else {
            //data already there no need to add data
        }
    } 
}
