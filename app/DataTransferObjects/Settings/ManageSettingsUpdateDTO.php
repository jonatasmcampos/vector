<?php

namespace App\DataTransferObjects\Settings;

use App\DataTransferObjects\Histories\CreateHistoryDTO;

class ManageSettingsUpdateDTO{
    private array $settings;
    private CreateHistoryDTO $history_dto;

    public function __construct(
        array $settings,
        CreateHistoryDTO $history_dto
    ){
        $this->settings = $settings;
        $this->history_dto = $history_dto;
    }

    public function getSettings(): array{
        return $this->settings;
    }
    public function getHistoryDto(): CreateHistoryDTO{
        return $this->history_dto;
    }
}