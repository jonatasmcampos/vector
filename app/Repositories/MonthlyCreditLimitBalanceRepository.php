<?php

namespace App\Repositories;

use App\Models\MonthlyCreditLimitBalance;

class MonthlyCreditLimitBalanceRepository {
    public function create(
        int $total_used_amount,
        int $balance,
        int $contract_id,
        int $credit_limit_id,
    ): MonthlyCreditLimitBalance{
        return MonthlyCreditLimitBalance::create([
            'total_used_amount' => $total_used_amount,
            'balance' => $balance,
            'contract_id' => $contract_id,
            'credit_limit_id' => $credit_limit_id
        ]);
    }

    /**
     * Retorna o saldo de limite de crédito para fins de validação de saldo.
     *
     * IMPORTANTE:
     * Esta função deve ser usada exclusivamente em operações que alteram
     * o saldo do limite de crédito, pois utiliza `lockForUpdate()` para
     * bloquear o registro no banco durante a transação. Isso evita
     * condições de corrida (race conditions) e garante que duas operações
     * simultâneas não utilizem o mesmo saldo ao mesmo tempo.
     *
     * Não utilizar esta função para consultas comuns.
     *
     */
    public function getMonthlyCreditLimitBalanceToCheck(
        int $month,
        int $year,
        int $contract_id,
        int $credit_usage_type_id,
        int $credit_modality_id
    ): ?MonthlyCreditLimitBalance{
        
        $credit_limit_balance = MonthlyCreditLimitBalance::whereRelation('credit_limit','month', $month)
            ->whereRelation('credit_limit', 'year', $year)
            ->whereRelation('credit_limit', 'contract_id', $contract_id)
            ->whereRelation('credit_limit', 'credit_usage_type_id', $credit_usage_type_id)
            ->whereRelation('credit_limit', 'credit_modality_id', $credit_modality_id)
            ->whereRelation('credit_limit', 'active', true)
            ->lockForUpdate()
            ->first();

        if(!$credit_limit_balance){
            throw new \Exception("Não há limite de crédito cadastrado no sistema!", 404);
        }

        return $credit_limit_balance;
    }

    public function update(
        int $credit_limit_balance_id,
        array $data_to_update
    ){
        $credit_limit_balance = MonthlyCreditLimitBalance::find($credit_limit_balance_id);
        return $credit_limit_balance->update($data_to_update);
    }
}