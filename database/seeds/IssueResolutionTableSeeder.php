<?php

use App\Models\Issue\ResolutionModel;
use Illuminate\Database\Seeder;

class IssueResolutionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ResolutionModel::create(['name' => 'Done']);
        ResolutionModel::create(['name' => 'Fixed']);
        ResolutionModel::create(['name' => 'Rejected']);
        ResolutionModel::create(['name' => 'Duplicate']);
        ResolutionModel::create(['name' => "Won't Fix"]);
        ResolutionModel::create(['name' => "Won't Do"]);
        ResolutionModel::create(['name' => 'Cannot Reproduce']);
    }
}
