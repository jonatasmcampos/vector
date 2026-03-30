<?php

namespace App\DataTransferObjects\Settings;

class UpdateSettingsDTO{
    private array $settings;

    public function __construct(
        array $settings
    ){
        $this->settings = $settings;
    }

    public function getSettings(): array{
        return $this->settings;
    }
}