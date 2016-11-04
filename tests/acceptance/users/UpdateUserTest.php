<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateUserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     * @test
     */
    public function it_updates_users_info()
    {
        $user = factory(\App\User::class)->create();

        $this->actingAs($user)
            ->visit(route('user.edit', $user->id))
            ->type('nuevoemail@example.com', 'email')
            ->press('Guardar');

        $this->seeInDatabase('users', ['email' => 'nuevoemail@example.com']);

        $this->seePageIs(route('user.edit', $user->id));
    }

    /**
     * @return void
     * @test
     */
    public function it_validates_fields()
    {
        $user = factory(\App\User::class)->create();
        $updateUri = route('user.update', $user->id);

        $this->actingAs($user)->call('PUT', $updateUri, []);

        $session = $this->app['session.store'];
        $this->assertNotNull($session->get('errors'));

        $this->seeInDatabase('users', ['email' => $user->email]);

    }

    /**
     * @return void
     * @test
     */
    public function auth_user_can_not_update_another_user()
    {
        $user = factory(\App\User::class)->create();
        $auth_user = factory(\App\User::class)->create();

        $updateUri = route('user.update', $user->id);

        $this->actingAs($auth_user)->call('PUT', $updateUri, [
            'name' => 'pedro'
        ]);

        $this->assertResponseStatus(403);

        $this->seeInDatabase('users', ['name' => $user->name]);
    }
}
