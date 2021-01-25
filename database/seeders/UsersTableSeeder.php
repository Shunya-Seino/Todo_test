<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
            'name' => 'テスト',
            'email' => 'sample@test.com',
            'password' => bcrypt('password'),
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        */
        for($i=0; $i<200; $i++){

            DB::table('users')->insert([
                'name' => 'テスト'.$i,
                'email' => 'test'.$i.'.com',
                'password' => bcrypt('pass'),
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
