<?php

namespace App\UseCases\Settings;

use App\Enums\CreditPeriodTypeEnum;
use App\Repositories\SettingsRepository;

class GetSettingsToCreditLimitCreationUseCase{

    private SettingsRepository $settings_repository;

    public function __construct(
        SettingsRepository $settings_repository
    ){
        $this->settings_repository = $settings_repository;
    }

    public function get(){
        return [
            'monthly_credit_period' => $this->isMonthlyCreditPeriod()
        ];
    }

    private function isMonthlyCreditPeriod(){
        return $this->settings_repository->getByKey('limit.supply-period-type')->value == CreditPeriodTypeEnum::MONTHLY->name;
    }
}