<?php

use App\Models\Issue\PriorityModel;
use Illuminate\Database\Seeder;

class IssuePrioritiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PriorityModel::create(['name' => 'Trivial']);
        PriorityModel::create(['name' => 'Minor']);
        PriorityModel::create(['name' => 'Medium']);
        PriorityModel::create(['name' => 'Major']);
        PriorityModel::create(['name' => 'Critical']);
    }
}
