<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class LoginFormRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer a request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Regras de validação.
     */
    public function rules(): array
    {
        return [
            'login'    => 'required|string',
            'password' => 'required|string',
        ];
    }

    /**
     * Mensagens personalizadas.
     */
    public function messages(): array
    {
        return [
            'login.required'    => 'O campo login é obrigatório.',
            'login.string'      => 'O login deve ser um texto válido.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.string'   => 'A senha deve ser um texto válido.'
        ];
    }

    /**
     * Resposta customizada em caso de falha na validação (JSON para API).
     */
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'message' => 'Erro de validação',
            'errors'  => $validator->errors()->all(),
        ], 422);

        throw new ValidationException($validator, $response);
    }
}