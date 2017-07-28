<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create(['name' => 'Alan', 'lastName' => 'Tello', 'email' => 'alan.tello@gmail.com', 'password' => bcrypt('1234')]);
        factory(User::class, 6)->create(['role_id' => 2]);

    }
}
