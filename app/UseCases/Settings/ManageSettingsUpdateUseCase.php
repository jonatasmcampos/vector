<?php

namespace App\UseCases\Settings;

use App\DataTransferObjects\Settings\ManageSettingsUpdateDTO;
use App\DataTransferObjects\Settings\UpdateSettingsDTO;
use App\DataTransferObjects\SettingsHistory\CreateSettingsHistoryDTO;
use App\Models\History;
use App\UseCases\Histories\CreateHistoryUseCase;
use Illuminate\Support\Collection;

class ManageSettingsUpdateUseCase{

    private UpdateSettingsUseCase $update_settings_use_case;
    private CreateSettingsHistoryUseCase $create_settings_history_use_case;
    private CreateHistoryUseCase $create_history_use_case;

    public function __construct(
        UpdateSettingsUseCase $update_settings_use_case,
        CreateSettingsHistoryUseCase $create_settings_history_use_case,
        CreateHistoryUseCase $create_history_use_case
    ){
        $this->update_settings_use_case = $update_settings_use_case;
        $this->create_settings_history_use_case = $create_settings_history_use_case;
        $this->create_history_use_case = $create_history_use_case;
    }

    public function handle(ManageSettingsUpdateDTO $dto): void{
        $settings = $this->updateSettings($dto);
        $this->createSettingsHistory($dto, $settings);
    }

    private function updateSettings(ManageSettingsUpdateDTO $dto): Collection{
        return $this->update_settings_use_case->handle(
            new UpdateSettingsDTO($dto->getSettings())
        );
    }

    private function createHistory(ManageSettingsUpdateDTO $dto): History{
        return $this->create_history_use_case->handle($dto->getHistoryDto());
    }

    private function createSettingsHistory(
        ManageSettingsUpdateDTO $dto,
        Collection $settings
    ): void{
        $history = $this->createHistory($dto);
        foreach ($settings as $key => $model) {
            $this->create_settings_history_use_case->handle(
                new CreateSettingsHistoryDTO(
                    $key,
                    $model->value,
                    $model->group_name,
                    $history->id
                )
            );
        }
    }
}