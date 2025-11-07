<?php 

namespace App\Repositories;

use App\Models\Contract;
use Illuminate\Support\Collection;

class ContractRepository {
    public function getAllContracts(): Collection{
        return Contract::get();
    }
}