<?php

namespace App\Http\Requests\PurchaseOrders;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class CreatePurchaseOrderFormRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            /** HEADER */
            'header'                   => 'required|array',
            'header.payload_type'      => 'required|string|in:ordem_de_compra',

            /** PAYLOAD ROOT */
            'payload'                  => 'required|array',

            /** PURCHASE ORDER */
            'payload.purchase_order'                                => 'required|array',
            'payload.purchase_order.user_master_cod'                => 'required|integer',
            'payload.purchase_order.contract_master_cod'            => 'required|integer',
            'payload.purchase_order.total'                          => 'required|decimal:0,2',
            'payload.purchase_order.external_identifier'            => 'required|integer',
            'payload.purchase_order.purchase_order_type_id'         => 'required|integer|exists:purchase_order_types,id',
            'payload.purchase_order.external_display_id'            => 'required|integer',
            'payload.purchase_order.total_items'                    => 'required|integer|min:1',
            'payload.purchase_order.cif'                            => 'required|decimal:0,2',
            'payload.purchase_order.fob'                            => 'required|decimal:0,2',
            'payload.purchase_order.supplier_id'                    => 'required|integer|exists:suppliers,id',
            'payload.purchase_order.discount'                       => 'required|decimal:0,2',
            'payload.purchase_order.payment_nature_id'              => 'required|integer|exists:payment_natures,id',
            'payload.purchase_order.payment_method_id'              => 'required|integer|exists:payment_methods,id',
            'payload.purchase_order.installment_quantity'           => 'required|integer|min:1',
            'payload.purchase_order.created_at'                     => 'required|date',

            /** MATERIALS */
            'payload.materials'                                     => 'required|array|min:1',
            'payload.materials.*.external_material_id'              => 'required|integer',
            'payload.materials.*.material'                          => 'required|string',
            'payload.materials.*.quantity'                          => 'required|decimal:0,2|min:0.01',
            'payload.materials.*.unit_amount'                       => 'required|decimal:0,2|min:0',
            'payload.materials.*.total_amount'                      => 'required|decimal:0,2|min:0',

            /** INSTALLMENTS */
            'payload.installments'                                  => 'required|array|min:1',
            'payload.installments.*.installment_amount_type_id'     => 'required|integer|exists:installment_amount_types,id',
            'payload.installments.*.order'                          => 'required|integer|min:1',
            'payload.installments.*.installment_amount'             => 'required|decimal:0,2|min:0',
            'payload.installments.*.installment_type_id'            => 'required|integer|exists:installment_types,id',
            'payload.installments.*.due_day'                        => 'required|date',
            'payload.installments.*.external_identifier'            => 'required|integer',
        ];
    }


    public function messages(): array
    {
        return [

            /** HEADER */
            'header.required'              => 'O header é obrigatório.',
            'header.array'                 => 'O header deve ser um array.',
            'header.payload_type.required' => 'O tipo de payload é obrigatório.',
            'header.payload_type.string'   => 'O tipo de payload deve ser um texto.',
            'header.payload_type.in'       => 'O tipo de payload deve ser "ordem_de_compra".',

            /** PAYLOAD ROOT */
            'payload.required' => 'O payload é obrigatório.',
            'payload.array'    => 'O payload deve ser um array.',

            /** PURCHASE ORDER */
            'payload.purchase_order.required' => 'Os dados da ordem de compra são obrigatórios.',
            'payload.purchase_order.array'    => 'Os dados da ordem de compra devem ser um array.',

            'payload.purchase_order.user_master_cod.required'   => 'O código do usuário master é obrigatório.',
            'payload.purchase_order.user_master_cod.integer'    => 'O código do usuário master deve ser um número inteiro.',

            'payload.purchase_order.contract_master_cod.required' => 'O código do contrato master é obrigatório.',
            'payload.purchase_order.contract_master_cod.integer'  => 'O código do contrato master deve ser um número inteiro.',

            'payload.purchase_order.total.required' => 'O total da ordem de compra é obrigatório.',
            'payload.purchase_order.total.decimal'  => 'O total deve ser um número válido.',
            'payload.purchase_order.total.min'      => 'O total deve ser no mínimo 0.',

            'payload.purchase_order.external_identifier.required' => 'O ID da solicitação é obrigatório.',
            'payload.purchase_order.external_identifier.integer'  => 'O ID da solicitação deve ser um número inteiro.',

            'payload.purchase_order.purchase_order_type_id.required' => 'O tipo de ordem de compra é obrigatório.',
            'payload.purchase_order.purchase_order_type_id.integer'  => 'O tipo de ordem deve ser um número inteiro.',
            'payload.purchase_order.purchase_order_type_id.exists'   => 'O tipo de ordem informado não existe.',

            'payload.purchase_order.external_display_id.required' => 'O ID de exibição é obrigatório.',
            'payload.purchase_order.external_display_id.integer'  => 'O ID de exibição deve ser um número inteiro.',

            'payload.purchase_order.total_items.required' => 'O total de itens é obrigatório.',
            'payload.purchase_order.total_items.integer'  => 'O total de itens deve ser um número inteiro.',
            'payload.purchase_order.total_items.min'      => 'O total de itens deve ser no mínimo 1.',

            'payload.purchase_order.cif.required' => 'O CIF é obrigatório.',
            'payload.purchase_order.cif.decimal'  => 'O CIF deve ser um número válido.',
            'payload.purchase_order.cif.min'      => 'O CIF deve ser no mínimo 0.',

            'payload.purchase_order.fob.required' => 'O FOB é obrigatório.',
            'payload.purchase_order.fob.decimal'  => 'O FOB deve ser um número válido.',
            'payload.purchase_order.fob.min'      => 'O FOB deve ser no mínimo 0.',

            'payload.purchase_order.supplier_id.required' => 'O fornecedor é obrigatório.',
            'payload.purchase_order.supplier_id.integer'  => 'O ID do fornecedor deve ser um número inteiro.',
            'payload.purchase_order.supplier_id.exists'   => 'O fornecedor informado não existe.',

            'payload.purchase_order.discount.required' => 'O desconto é obrigatório.',
            'payload.purchase_order.discount.decimal'  => 'O desconto deve ser um número válido.',
            'payload.purchase_order.discount.min'      => 'O desconto deve ser no mínimo 0.',

            'payload.purchase_order.payment_nature_id.required' => 'A natureza de pagamento é obrigatória.',
            'payload.purchase_order.payment_nature_id.integer'  => 'A natureza de pagamento deve ser um número inteiro.',
            'payload.purchase_order.payment_nature_id.exists'   => 'A natureza de pagamento informada não existe.',

            'payload.purchase_order.payment_method_id.required' => 'O método de pagamento é obrigatório.',
            'payload.purchase_order.payment_method_id.integer'  => 'O método de pagamento deve ser um número inteiro.',
            'payload.purchase_order.payment_method_id.exists'   => 'O método de pagamento informado não existe.',

            'payload.purchase_order.installment_quantity.required' => 'A quantidade de parcelas é obrigatória.',
            'payload.purchase_order.installment_quantity.integer'  => 'A quantidade de parcelas deve ser um número inteiro.',
            'payload.purchase_order.installment_quantity.min'      => 'A ordem de compra deve possuir pelo menos 1 parcela.',

            'payload.purchase_order.created_at.required' => 'A data de criação é obrigatória.',
            'payload.purchase_order.created_at.date'     => 'A data de criação deve ser uma data válida.',

            /** MATERIALS */
            'payload.materials.required' => 'A lista de materiais é obrigatória.',
            'payload.materials.array'    => 'A lista de materiais deve ser um array.',
            'payload.materials.min'      => 'A lista de materiais deve conter no mínimo 1 material.',

            'payload.materials.*.external_material_id.required' => 'O ID do material é obrigatório.',
            'payload.materials.*.external_material_id.integer'  => 'O ID do material deve ser um número inteiro.',

            'payload.materials.*.material.required' => 'O nome do material é obrigatório.',
            'payload.materials.*.material.string'   => 'O nome do material deve ser um texto.',

            'payload.materials.*.quantity.required' => 'A quantidade do material é obrigatória.',
            'payload.materials.*.quantity.numeric'  => 'A quantidade deve ser um número.',
            'payload.materials.*.quantity.min'      => 'A quantidade deve ser no mínimo 0.0001.',

            'payload.materials.*.unit_amount.required' => 'O valor unitário é obrigatório.',
            'payload.materials.*.unit_amount.numeric'  => 'O valor unitário deve ser numérico.',
            'payload.materials.*.unit_amount.min'      => 'O valor unitário deve ser no mínimo 0.',

            'payload.materials.*.total_amount.required' => 'O valor total é obrigatório.',
            'payload.materials.*.total_amount.numeric'  => 'O valor total deve ser numérico.',
            'payload.materials.*.total_amount.min'      => 'O valor total deve ser no mínimo 0.',

            /** INSTALLMENTS */
            'payload.installments.required' => 'A lista de parcelas é obrigatória.',
            'payload.installments.array'    => 'A lista de parcelas deve ser um array.',
            'payload.installments.min'      => 'A lista de parcelas deve conter no mínimo 1 parcela.',

            'payload.installments.*.installment_amount_type_id.required' => 'O tipo de valor da parcela é obrigatório.',
            'payload.installments.*.installment_amount_type_id.integer'  => 'O tipo de valor da parcela deve ser um número inteiro.',
            'payload.installments.*.installment_amount_type_id.exists'   => 'O tipo de valor da parcela informado é inválido.',

            'payload.installments.*.order.required' => 'A ordem da parcela é obrigatória.',
            'payload.installments.*.order.integer'  => 'A ordem da parcela deve ser um número inteiro.',
            'payload.installments.*.order.min'      => 'A parcela deve ter ordem mínima de 1.',

            'payload.installments.*.installment_amount.required' => 'O valor da parcela é obrigatório.',
            'payload.installments.*.installment_amount.numeric'  => 'O valor da parcela deve ser numérico.',
            'payload.installments.*.installment_amount.min'      => 'O valor da parcela deve ser no mínimo 0.',

            'payload.installments.*.installment_type_id.required' => 'O tipo da parcela é obrigatório.',
            'payload.installments.*.installment_type_id.integer'  => 'O tipo da parcela deve ser um número inteiro.',
            'payload.installments.*.installment_type_id.exists'   => 'O tipo da parcela informado é inválido.',

            'payload.installments.*.due_day.required' => 'A data de vencimento da parcela é obrigatória.',
            'payload.installments.*.due_day.date'     => 'A data de vencimento deve ser uma data válida.',

            'payload.installments.*.external_identifier.required' => 'O ID da parcela é obrigatório.',
            'payload.installments.*.external_identifier.integer'  => 'O ID da parcela deve ser um número inteiro.',
        ];
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
