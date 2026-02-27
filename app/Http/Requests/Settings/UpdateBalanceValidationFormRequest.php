<?php

namespace App\Http\Requests\Settings;

use App\Enums\SettingsEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UpdateBalanceValidationFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'settings' => ['nullable', 'array'],

            'settings.*' => [
                'nullable',
                Rule::in(['0', '1', 0, 1, true, false]),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'settings.array'    => 'As configurações devem ser enviadas em formato de lista.',
            'settings.*.in'     => 'Valor inválido para uma das configurações.',
        ];
    }


    /**
     * Retorna TODAS as settings do grupo,
     * preenchendo as que não vieram como false
     */
    public function validatedSettings(): array
    {
        $submitted = $this->input('settings', []);

        $validateBalanceEnums = collect(SettingsEnum::cases())
            ->filter(fn ($enum) => str_starts_with($enum->value, 'validate-balance'));

        return $validateBalanceEnums
            ->mapWithKeys(fn ($enum) => [
                $enum->value => isset($submitted[$enum->value])
                    ? true
                    : false
            ])
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
