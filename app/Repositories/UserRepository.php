<?php 

namespace App\Repositories;

use App\Models\User;

class UserRepository {
    public function getUserByLogin(
        string $login
    ): ?User{
        $user = User::where('login', $login)->first();
        if(!$user){
            throw new \Exception("Credenciais inválidas!", 401);
        }
        return $user;
    }
}