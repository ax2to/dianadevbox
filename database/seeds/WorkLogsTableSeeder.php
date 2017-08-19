<?php

use Illuminate\Database\Seeder;

class WorkLogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\WorkLogModel::class, 120)->create();
    }
}
