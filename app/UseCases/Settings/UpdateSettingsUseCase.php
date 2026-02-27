<?php

namespace App\UseCases\Settings;

use App\DataTransferObjects\Settings\UpdateSettingsDTO;
use App\Repositories\SettingsRepository;
use Illuminate\Support\Collection;

class UpdateSettingsUseCase{

    private SettingsRepository $settings_repository;

    public function __construct(
        SettingsRepository $settings_repository
    ){
        $this->settings_repository = $settings_repository;
    }

    public function handle(
        UpdateSettingsDTO $dto
    ): Collection {
        return $this->update($dto);
    }

    private function update(UpdateSettingsDTO $dto): Collection{
        return collect($dto->getSettings())->map(function($value, $key){
            return $this->settings_repository->update($key, $value);
        });
    }
}