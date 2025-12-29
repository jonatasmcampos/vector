<?php

namespace App\Repositories;

use App\Models\TotalMonthlyInstallment;

class TotalMonthlyInstallmentRepository{
    public function create(
        int $gross_amount,
        int $paid_amount,
		int $month,
        int $year,
        int $contract_id
    ): TotalMonthlyInstallment{
        return TotalMonthlyInstallment::create([
            'gross_amount' =>$gross_amount,
            'paid_amount' => $paid_amount,
		    'month' => $month,
            'year' => $year,
            'contract_id' => $contract_id
        ]);
    }

    public function updateById(
        int $total_monthly_installment_id,
        array $data
    ){
        $total_monthly_installment = TotalMonthlyInstallment::find($total_monthly_installment_id);
        if(!$total_monthly_installment){
            throw new \Exception("Valor total mensal não encontrado!", 404);
        }
        return $total_monthly_installment->update($data);
    }

    public function getByMonthAndYearAndContractId(
        int $month,
        int $year,
        int $contract_id
    ): ?TotalMonthlyInstallment{
        return TotalMonthlyInstallment::where('month', $month)
            ->where('year', $year)
            ->where('contract_id', $contract_id)
            ->first();
    }
}