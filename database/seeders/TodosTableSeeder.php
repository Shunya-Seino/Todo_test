<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 202) as $num) {
            DB::table('todos')->insert([
                'id' => $num,
                'user_id' => 1,
                'title' => "サンプルタスク {$num}",
                'detail' => "サンプルタスクの内容 {$num}",
                'status' => 4,
                'due_date' => Carbon::now()->addDay($num * 2),
                'start_date' => Carbon::now()->addDay($num),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}