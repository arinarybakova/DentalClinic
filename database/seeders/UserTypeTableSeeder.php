<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UserTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table('user_type')->count();
        if($count == 0) {
            DB::table('user_type')->insert([
                ['name' => 'admin'],
                ['name' => 'patient'],
                ['name' => 'dentist']
            ]);
        }
        else {
            //data already there no need to add data
        }
    }
}
