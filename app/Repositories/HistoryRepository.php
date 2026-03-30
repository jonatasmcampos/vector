<?php

namespace App\Repositories;

use App\Models\History;
use Carbon\Carbon;

class HistoryRepository{
    public function create(
        Carbon $date,
        ?string $observation = null,
        int $user_id,
        int $action_id,
        int $process_id,
        int $contract_id
    ): History{
        return History::create([
            'date' => $date,
            'observation' => $observation,
            'user_id' => $user_id,
            'action_id' => $action_id,
            'process_id' => $process_id,
            'contract_id' => $contract_id
        ]);
    }

    public function getHistoryById(
        int $history_id
    ): ?History{
        $history = History::find($history_id);
        if(!$history){
            throw new \Exception("Histórico não encontrado para o ID ". $history_id, 404);         
        }
        return $history;
    }
}