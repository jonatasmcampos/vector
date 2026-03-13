<?php

namespace App\UseCases\Settings;

use App\DataTransferObjects\Settings\GetDataToSettingsViewDTO;
use App\DataTransferObjects\Settings\PreparedDataToSettingsViewDTO;
use App\Enums\CreditUsageTypeEnum;
use App\Models\User;
use App\Repositories\SettingsRepository;
use App\Repositories\UserRepository;

class GetDataToSettingsViewUseCase{

    private UserRepository $user_repository;
    private SettingsRepository $settings_repository;

    public function __construct(
        UserRepository $user_repository,
        SettingsRepository $settings_repository
    ){
        $this->user_repository = $user_repository;
        $this->settings_repository = $settings_repository;
    }

    public function handle(GetDataToSettingsViewDTO $dto): PreparedDataToSettingsViewDTO{
        $user = $this->getUser($dto);
        return new PreparedDataToSettingsViewDTO(
            user_name: $user->name,
            user_login:$user->login,
            user_email:$user->email,
            cpf: $user->cpf,
            phone: $user->phone,
            balance_validation_group: $this->getBalanceValidationGroup(),
            credit_usage_types: CreditUsageTypeEnum::getAll()
        );
    }

    private function getBalanceValidationGroup(): array{
         return $this->settings_repository
            ->getByGroup('validate-balance')
            ->mapWithKeys(fn ($setting) => [
                $setting->key => $setting->value()
            ])
            ->toArray();
    }

    private function getUser(GetDataToSettingsViewDTO $dto): ?User{
        return $this->user_repository->getById($dto->getUserId());
    }
}