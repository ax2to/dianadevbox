<?php

namespace Tests\Feature\Users;

use App\User;
use Tests\TestCase;

class CreateTest extends TestCase
{
    private $url = 'users/create';

    public function testLinkOnNavigation()
    {
        $this->visit('/')
            ->click('Create User')
            ->seePageIs($this->url);
    }

    public function testAvailableFieldsOnForm()
    {
        $this->visit($this->url)
            ->see('Name')
            ->see('Last Name')
            ->see('Email')
            ->see('Password')
            ->see('Confirm Password')
            ->see('Role')
            ->see('TimeZone')
            ->see('Save');
    }

    public function testCreateUser()
    {
        $user = factory(User::class)->make();
        $this->visit($this->url)
            ->type($user->name, 'name')
            ->type($user->lastName, 'lastName')
            ->type($user->email, 'email')
            ->type($user->password, 'password')
            ->type($user->password, 'password_confirmation')
            ->press('Save')
            ->see(sprintf('The user, %s, was created successfully.', $user->fullName));
    }

    protected function setUp()
    {
        parent::setUp();

        // auth
        $this->actingAs(User::find(1));
    }
}
