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
        PriorityModel::create(['name' => 'Trivial', 'order' => 1]);
        PriorityModel::create(['name' => 'Minor', 'order' => 2]);
        PriorityModel::create(['name' => 'Medium', 'order' => 3]);
        PriorityModel::create(['name' => 'Major', 'order' => 4]);
        PriorityModel::create(['name' => 'Critical', 'order' => 5]);
    }
}
