<?php

use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected $userRepository;

    public function setUp()
    {
        parent::setUp();
        $this->userRepository = $this->app->make(UserRepository::class);
    }

    /**
     * @return void
     * @test
     */
    public function it_finds_users_by_instagram_id()
    {
        $user = factory(\App\User::class)->create();
        $data = ['instagram_id' => $user->instagram_id];
        $found_user = $this->userRepository->findOrCreateInstagramUser($data);
        $this->assertEquals($found_user->name, $user->name);
    }

    /**
     * @return void
     * @test
     */
    public function it_creates_a_user_by_instagram_data()
    {
        $user = factory(\App\User::class)->make();
        $data = [
            'instagram_id' => $user->instagram_id,
            'name' => $user->name,
            'email' => null,
            'avatar' => $user->avatar
        ];
        $new_user = $this->userRepository->findOrCreateInstagramUser($data);
        $this->assertInstanceOf(\App\User::class, $new_user);
        $this->seeInDatabase('users', $data);
    }

}
