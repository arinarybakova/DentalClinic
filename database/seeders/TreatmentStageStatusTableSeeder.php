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
        DB::table('treatment_stage_status')->insert([
            ['status' => 'Laukiama'],
            ['status' => 'Atlikta'],
            ['status' => 'Atšaukta']
        ]);
    }
}
