<?php 

namespace App\UseCases\Histories;

use App\DataTransferObjects\Histories\CreateHistoryDTO;
use App\Repositories\HistoryRepository;

class CreateHistoryUseCase{
    private HistoryRepository $history_repository;

    public function __construct(HistoryRepository $history_repository)
    {
        $this->history_repository = $history_repository;
    }

    public function handle(CreateHistoryDTO $create_history_dto){
        return $this->create($create_history_dto);
    }

    private function create(CreateHistoryDTO $create_history_dto){
        return $this->history_repository->create(
            $create_history_dto->getDate(),
            $create_history_dto->getObservation(),
            $create_history_dto->getUserId(),
            $create_history_dto->getActionId(),
            $create_history_dto->getProcessId(),
            $create_history_dto->getContractId()
        );
    }
}