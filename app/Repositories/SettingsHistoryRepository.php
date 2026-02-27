<?php 

namespace App\Repositories;

use App\Models\SettingsHistory;

class SettingsHistoryRepository{
    public function create(
        string $key,
        mixed $value,
        string $group_name,
        int $history_id
    ): SettingsHistory{
        return SettingsHistory::create([
            'key' => $key,
            'value' => $value,
            'group_name' => $group_name,
            'history_id' => $history_id,
        ]);
    }
}