<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testRedirectToLogin()
    {
        $this->visit('/')
            ->seePageIs('login');
    }

    public function testLoginForm()
    {
        $this->visit('login')
            ->see('Login')
            ->see('EMail')
            ->see('Password');
    }

    public function testLoginSuccess()
    {
        $this->visit('login')
            ->type('alan.tello@gmail.com','email')
            ->type('123456','password')
            ->press('Login')
            ->seePageIs('/');
    }
}
