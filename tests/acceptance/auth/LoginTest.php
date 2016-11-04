<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     * @test
     */
    public function it_lets_users_login()
    {
        $plain_password = str_random(10);
        $user = factory(\App\User::class)->create([
            'password' => bcrypt($plain_password)
        ]);

        $this->visit('/login')
            ->type($user->email, 'email')
            ->type($plain_password, 'password')
            ->press('Login');

        $this->seePageIs('/')
            ->see($user->name);
    }
}
