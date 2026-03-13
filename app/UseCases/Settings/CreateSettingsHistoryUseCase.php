<?php

namespace App\UseCases\Settings;

use App\DataTransferObjects\SettingsHistory\CreateSettingsHistoryDTO;
use App\Models\SettingsHistory;
use App\Repositories\SettingsHistoryRepository;

class CreateSettingsHistoryUseCase{

    private SettingsHistoryRepository $settings_history_repository;

    public function __construct(
        SettingsHistoryRepository $settings_history_repository
    ){
        $this->settings_history_repository = $settings_history_repository;
    }

    public function handle(CreateSettingsHistoryDTO $dto): SettingsHistory{
        return $this->create($dto);
    }

    private function create(CreateSettingsHistoryDTO $dto): SettingsHistory{
        return $this->settings_history_repository->create(
            $dto->getKey(),
            $dto->getValue(),
            $dto->getGroupName(),
            $dto->getHistoryId()
        );
    }
}