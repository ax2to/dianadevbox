<?php

use App\Models\Issue\StatusModel;
use Illuminate\Database\Seeder;

class IssueStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StatusModel::create(['name' => 'New']);
        StatusModel::create(['name' => 'Opened']);
        StatusModel::create(['name' => 'In Progress']);
        StatusModel::create(['name' => 'Resolved']);
        StatusModel::create(['name' => 'Closed']);;
    }
}