<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\LoginDTO;
use App\Http\Requests\LoginFormRequest;
use App\UseCases\LoginUseCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
    private LoginUseCase $login_use_case;
    
    public function __construct(
        LoginUseCase $login_use_case,
    ){
        $this->login_use_case = $login_use_case;
    }

    public function login(LoginFormRequest $request)
    {
        return DB::transaction(function() use ($request){
            $login_dto = new LoginDTO($request->validated());
            return $this->login_use_case->handle($login_dto);
        });
    }

    public function logout(Request $request){
        return DB::transaction(function() use ($request){
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'success' => true,
                'message' => 'Logout realizado com sucesso'
            ]);
        });
    }
}
