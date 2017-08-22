<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // settings
        $this->call(RoleTableSeeder::class);
        $this->call(IssueTypeTableSeeder::class);
        $this->call(IssueResolutionTableSeeder::class);
        $this->call(IssuePrioritiesTableSeeder::class);
        $this->call(IssueStatusTableSeeder::class);
        // data
        $this->call(CompaniesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
        $this->call(IssuesTableSeeder::class);
        $this->call(WorkLogsTableSeeder::class);
    }
}