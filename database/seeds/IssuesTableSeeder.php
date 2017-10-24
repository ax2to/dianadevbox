<?php

use Illuminate\Database\Seeder;

class IssuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\IssueModel::class, 60)->create();
        factory(\App\Models\IssueModel::class, 60)->create(['type_id' => 5]);
    }
}
