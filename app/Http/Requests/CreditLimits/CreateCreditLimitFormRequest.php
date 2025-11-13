<?php

namespace App\Http\Requests\CreditLimits;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class CreateCreditLimitFormRequest extends FormRequest
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
            'authorized_amount'     => 'required|string',
            'month'                 => 'required|integer|min:1|max:12',
            'contract_id'           => 'required|integer|exists:contracts,id',
            'credit_usage_type_id'  => 'required|integer|exists:credit_usage_types,id',
            'credit_modality_id'    => 'required|integer|exists:credit_modalities,id',
            'credit_period_type_id' => 'required|integer|exists:credit_period_types,id',
        ];
    }

    /**
     * Mensagens personalizadas.
     */
    public function messages(): array
    {
        return [
            'authorized_amount.required' => 'O valor autorizado é obrigatório.',
            'authorized_amount.string'   => 'O valor autorizado deve ser um valor em reais (R$).',

            'month.required' => 'O mês é obrigatório.',
            'month.integer'  => 'O mês deve ser um número inteiro.',
            'month.min'      => 'O mês deve ser no mínimo 1.',
            'month.max'      => 'O mês deve ser no máximo 12.',

            'contract_id.required' => 'O contrato é obrigatório.',
            'contract_id.integer'  => 'O ID do contrato deve ser um número inteiro.',
            'contract_id.exists'   => 'O contrato informado não existe no sistema.',

            'credit_usage_type_id.required' => 'O tipo de uso de crédito é obrigatório.',
            'credit_usage_type_id.integer'  => 'O ID do tipo de uso deve ser um número inteiro.',
            'credit_usage_type_id.exists'   => 'O tipo de uso informado não existe.',

            'credit_modality_id.required' => 'A modalidade de crédito é obrigatória.',
            'credit_modality_id.integer'  => 'O ID da modalidade deve ser um número inteiro.',
            'credit_modality_id.exists'   => 'A modalidade informada não existe.',

            'credit_period_type_id.required' => 'O tipo do período é obrigatório.',
            'credit_period_type_id.integer'  => 'O ID do período deve ser um número inteiro.',
            'credit_period_type_id.exists'   => 'O tipo de período informado não existe.',
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
