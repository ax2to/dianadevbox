<?php

use App\Models\WorkflowModel;
use Illuminate\Database\Seeder;

class WorkflowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(WorkflowModel::class)->create(['name' => 'default']);
        factory(WorkflowModel::class)->create(['name' => 'leads']);
    }
}
