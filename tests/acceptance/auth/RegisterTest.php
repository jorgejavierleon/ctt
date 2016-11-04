<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     * @test
     */
    public function it_register_a_user()
    {
        $user = factory(\App\User::class)->make();

        $this->visit('/register')
            ->type($user->name, 'name')
            ->type($user->email, 'email')
            ->type('123456', 'password')
            ->type('123456', 'password_confirmation')
            ->press('Registrar');

        $this->seeInDatabase('users', ['name' => $user->name]);
        $this->seePageIs('/')
            ->see($user->name);


    }
}
