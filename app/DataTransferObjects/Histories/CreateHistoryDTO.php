<?php 

namespace App\DataTransferObjects\Histories;

use Carbon\Carbon;

class CreateHistoryDTO{
    
    private Carbon $date;
    private ?string $observation;
    private int $user_id;
    private int $action_id;
    private int $process_id;
    private int $contract_id;

    public function __construct(
        Carbon $date,
        ?string $observation = null,
        int $user_id,
        int $action_id,
        int $process_id,
        int $contract_id,
    ){
        $this->date = $date;
        $this->observation = $observation;
        $this->user_id = $user_id;
        $this->action_id = $action_id;
        $this->process_id = $process_id;
        $this->contract_id = $contract_id;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getActionId(): int
    {
        return $this->action_id;
    }

    public function getProcessId(): int
    {
        return $this->process_id;
    }

    public function getContractId(): int
    {
        return $this->contract_id;
    }
    
}