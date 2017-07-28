<?php

use App\Models\ProjectModel;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectModel::create(['name' => 'DianaDevBox']);
        ProjectModel::create(['name' => 'SimpleM2M']);
        ProjectModel::create(['name' => 'Wortix']);
    }
}
