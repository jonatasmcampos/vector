<?php

namespace App\DataTransferObjects\InstallmentHistory;

use App\Models\Installment;
use Illuminate\Database\Eloquent\Collection;

class CreateInstallmentHistoryDTO{

    /**
     * @var Collection<int, Installment>
     */
    private Collection $installments;
    private int $history_id;

    public function __construct(
        Collection $installments,
        int $history_id
    ) {
        $this->history_id = $history_id;
        $this->installments = $installments;
    }

    /**
     * @return Collection<int, Installment>
     */
    public function getInstallments(): Collection
    {
        return $this->installments;
    }

    public function getHistoryId(): int
    {
        return $this->history_id;
    }
}