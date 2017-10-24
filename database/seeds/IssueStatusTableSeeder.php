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
        StatusModel::create(['name' => 'Closed']);

        $workflow_id = 2;
        StatusModel::create(['name' => 'New', 'workflow_id' => $workflow_id]);
        StatusModel::create(['name' => 'Pending', 'workflow_id' => $workflow_id]);
        StatusModel::create(['name' => 'Closed', 'workflow_id' => $workflow_id]);
        StatusModel::create(['name' => 'Trash', 'workflow_id' => $workflow_id]);
        StatusModel::create(['name' => 'Sale', 'workflow_id' => $workflow_id]);
    }
}