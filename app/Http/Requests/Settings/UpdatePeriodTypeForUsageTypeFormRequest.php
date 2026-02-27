<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UpdatePeriodTypeForUsageTypeFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'settings' => ['required', 'array'],

            'settings.*' => [
                'required',
                'string',
                'in:monthly,rotative',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'settings.required'     => 'As configurações devem ser enviadas.',
            'settings.array'        => 'As configurações devem estar no formato de lista.',
            'settings.*.required'   => 'Uma das configurações não foi enviada.',
            'settings.*.in'         => 'O período deve ser mensal ou rotativo.',
        ];
    }

    /**
     * Retorna apenas settings válidas de limit period type
     */
    public function validatedSettings(): array
    {
        return collect($this->validated()['settings'])
            ->filter(function ($value, $key) {
                return str_starts_with($key, 'limit.')
                    && str_ends_with($key, '-period-type');
            })
            ->toArray();
    }

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