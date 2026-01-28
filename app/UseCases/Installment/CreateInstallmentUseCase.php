<?php

namespace App\UseCases\Installment;

use App\DataTransferObjects\Installment\CreateInstallmentDTO;
use App\Domain\Contracts\Installment\InstallmentableInterface;
use App\Domain\ValueObjects\AmountInCents;
use Illuminate\Database\Eloquent\Collection;

class CreateInstallmentUseCase{

    public function handle(CreateInstallmentDTO $create_installment_dto): Collection{
        return $this->createInstallments(
            $create_installment_dto->getInstallmentable(),
            $create_installment_dto->getInstallments()
        );
    }

    private function createInstallments(
        InstallmentableInterface $installmentable,
        array $installments
    ): Collection{        
        $sanitize_installments = $this->sanitizeInstallments($installments, $installmentable->getContractId());
        return $installmentable->installments()->createMany($sanitize_installments);
    }
    
    private function sanitizeInstallments(
        array $installments,
        int $contract_id
    ): array{
        return array_map(function($installment) use ($contract_id){
            return [
                "installment_amount_type_id" => (int)$installment['installment_amount_type_id'],
                "order" => (int)$installment['order'],
                "installment_amount" => AmountInCents::fromFloat($installment['installment_amount'])->value(),
                "amount_paid" => 0,
                "installment_type_id" => (int)$installment['installment_type_id'],
                "due_day" => $installment['due_day'],
                "external_identifier" => (int)$installment['external_identifier'],
                "contract_id" => $contract_id
            ];
        }, $installments);
    }
}