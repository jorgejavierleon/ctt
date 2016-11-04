<?php


namespace App\Auth;


use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class InstagramAuth
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * InstagramAuth constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute($hasCode, $listener)
    {
        if( ! $hasCode) return $this->getAuthorization();

        $user = $this->userRepository->findOrCreateInstagramUser($this->getInstagramData());

        Auth::login($user);

        return $listener->userHasLoggedInByInstagram($user);
    }

    /**
     * @return mixed
     */
    private function getAuthorization()
    {
        return Socialite::with('instagram')->redirect();
    }


    /**
     * @return array
     */
    private function getInstagramData()
    {
        $user = Socialite::driver('instagram')->user();
        return [
            'instagram_id' => $user->id,
            'name' => $user->nickname,
            'email' => $user->email,
            'avatar' => $user->avatar
        ];
    }
}