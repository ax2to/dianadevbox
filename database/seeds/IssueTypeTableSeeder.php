<?php

use App\Models\Issue\TypeModel;
use Illuminate\Database\Seeder;

class IssueTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeModel::create(['name' => 'Task']);
        TypeModel::create(['name' => 'Bug']);
        TypeModel::create(['name' => 'Improvement']);
        TypeModel::create(['name' => 'New Feature']);
        TypeModel::create(['name' => 'Ticket']);
    }
}
