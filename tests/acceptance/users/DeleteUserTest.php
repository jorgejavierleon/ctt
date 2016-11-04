<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeleteUserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     * @test
     */
    public function it_deletes_a_user()
    {
        $user = factory(\App\User::class)->create();
        $this->actingAs($user)
            ->visit(route('user.edit', $user->id))
            ->press('Eliminar cuenta');

        $this->dontSeeInDatabase('users', ['name' => $user->name]);
        $this->seePageIs('/');
    }
}
