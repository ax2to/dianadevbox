<?php

use App\Models\RoleModel;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoleModel::create(['name' => 'Admin']);
        RoleModel::create(['name' => 'User']);
    }
}
