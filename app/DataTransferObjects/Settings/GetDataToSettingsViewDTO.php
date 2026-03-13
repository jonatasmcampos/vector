<?php

namespace App\DataTransferObjects\Settings;

class GetDataToSettingsViewDTO{
    private int $user_id;

    public function __construct(
        int $user_id
    ){
        $this->user_id = $user_id;
    }

    public function getUserId(): int{
        return $this->user_id;
    }
}