<?php

namespace App\UseCases;

use App\DataTransferObjects\LoginDTO;
use App\Enums\ProcessEnum;
use App\Models\User;
use App\Repositories\ProcessRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class LoginUseCase {

    private UserRepository $user_repository;
    private ProcessRepository $process_repository;

    public function __construct(
        UserRepository $user_repository,
        ProcessRepository $process_repository
    ){
        $this->user_repository = $user_repository;
        $this->process_repository = $process_repository;
    }

    public function handle(LoginDTO $request){
    
        $user = $this->getUser($request->getLogin());
        $this->verifyPassword($request->getPassword(), $user->password);
        $this->saveUserDataInSession($user);
        $this->saveProcessesInSession();

        return response()->json([
            'success' => true,
            'message' => 'Login realizado com sucesso!'
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

    private function saveUserDataInSession(User $user){
        session()->put('user', [
            'id' => $user->id,
            'name' => $user->name,
            'group' => $user->user_group->name
        ]);
    }

    private function saveProcessesInSession(){
        $processes = $this->process_repository->getAll();
        $permissions = [];
        foreach ($processes as $key => $process) {
            $permissions[$process->menu][$process->order] = [
                "name" => $process->name,
                "description" => $process->description,
                "route" => $process->route,
                "order" => $process->order,
                "icon" => $process->icon,
                "process" => $process->process,
            ];
        }
        foreach ($permissions as &$items) {
            ksort($items);
        }
        unset($items);
        session()->put('permissions', $permissions);
    }
}