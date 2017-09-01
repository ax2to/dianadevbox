<?php

namespace Tests\Feature\Users;

use App\User;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function testPopulatedForm()
    {
        $user = User::find(1);
        $this->visit("users/{$user->id}/edit")
            ->seeInField('name', $user->name)
            ->seeInField('lastName', $user->lastName)
            ->seeInField('email', $user->email)
            ->seeIsSelected('role_id', $user->role_id)
            ->seeIsSelected('timezone', $user->timezone);
    }

    public function testUpdateUser()
    {
        $user = User::find(1);
        $this->visit("users/{$user->id}/edit");
    }

    protected function setUp()
    {
        parent::setUp();

        // auth
        $this->actingAs(User::find(1));
    }
}
