<?php

namespace App\UseCases;

use App\DataTransferObjects\LoginDTO;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class LoginUseCase {

    private UserRepository $user_repository;

    public function __construct(
        UserRepository $user_repository
    ){
        $this->user_repository = $user_repository;
    }

    public function handle(LoginDTO $request){
    
        $user = $this->getUser($request->getLogin());
        $this->verifyPassword($request->getPassword(), $user->password);
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login realizado com sucesso!',
            'api_token' => $token,
            'data' => $this->getData($user)
        ]);
    }

    private function getUser(string $login): User{
        return $this->user_repository->getUserByLogin($login);
    }

    private function verifyPassword(string $login_password, string $saved_password){
        if (!Hash::check($login_password, $saved_password)) {
            throw new \Exception("Credenciais inválidas!", 401);
        }
    }

    private function getData(User $user): array{
        return [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_group' => $user->user_group->name
        ];
    }
}