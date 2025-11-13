<?php

namespace App\Repositories;

use App\Models\History;
use Carbon\Carbon;

class HistoryRepository{
    public function create(
        Carbon $date,
        ?string $observation = null,
        string $model,
        int $user_id,
        int $action_id,
        int $process_id,
        int $contract_id
    ): History{
        return History::create([
            'date' => $date,
            'observation' => $observation,
            'model' => $model,
            'user_id' => $user_id,
            'action_id' => $action_id,
            'process_id' => $process_id,
            'contract_id' => $contract_id
        ]);
    }
}