<?php 

namespace App\DataTransferObjects\Home;

class GetDataToDashboardDTO{
    private int $month;
    private int $year;
    private int $contract_id;
    private int $credit_usage_type_id;

    public function __construct(
        int $month,
        int $year,
        int $contract_id,
        int $credit_usage_type_id
    ){
        $this->month = $month;
        $this->year = $year;
        $this->contract_id = $contract_id;
        $this->credit_usage_type_id = $credit_usage_type_id;
    }

    public function getMonth(): int{
        return $this->month;
    }

    public function getYear(): int{
        return $this->year;
    }

    public function getContractId(): int{
        return $this->contract_id;
    }

    public function getCreditUsageTypeId(): int{
        return $this->credit_usage_type_id;
    }
}