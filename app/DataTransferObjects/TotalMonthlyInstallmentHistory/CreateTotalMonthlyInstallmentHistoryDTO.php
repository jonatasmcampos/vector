<?php

namespace App\DataTransferObjects\TotalMonthlyInstallmentHistory;

use App\DataTransferObjects\TotalMonthlyInstallment\TotalMonthlyInstallmentManagementValuesDTO;

class CreateTotalMonthlyInstallmentHistoryDTO
{
    private int $history_id;

    /**
     * @var TotalMonthlyInstallmentManagementValuesDTO[]
     */
    private array $management_values;

    /**
     * @param TotalMonthlyInstallmentManagementValuesDTO[] $management_values
     */
    public function __construct(
        int $history_id,
        array $management_values
    ) {
        $this->history_id = $history_id;
        $this->management_values = $management_values;
    }

    public function getHistoryId(): int
    {
        return $this->history_id;
    }

    /**
     * @return TotalMonthlyInstallmentManagementValuesDTO[]
     */
    public function getManagementValues(): array
    {
        return $this->management_values;
    }
}
