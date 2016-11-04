<?php


namespace App\Repositories;


use App\User;

class UserRepository
{
    /**
     * @param $data
     * @return static
     */
    public function findOrCreateInstagramUser($data)
    {
        $user = User::where('instagram_id', $data['instagram_id'])->first();

        if($user){
            return $user;
        }

        return User::create($data);
        
    }
}