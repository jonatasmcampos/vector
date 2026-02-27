<?php

namespace App\DataTransferObjects\SettingsHistory;

class CreateSettingsHistoryDTO{
    private string $key;
    private mixed $value;
    private string $group_name;
    private int $history_id;

    public function __construct(
        string $key,
        mixed $value,
        string $group_name,
        int $history_id
    ){
        $this->key = $key;
        $this->value = $value;
        $this->group_name = $group_name;
        $this->history_id = $history_id;
    }

    public function getKey(): string{
        return $this->key;
    }
    public function getValue(): string{
        return $this->value;
    }
    public function getGroupName(): string{
        return $this->group_name;
    }
    public function getHistoryId(): string{
        return $this->history_id;
    }
}