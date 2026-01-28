<?php 

namespace App\Repositories;

use App\Models\Process;

class ProcessRepository {
    public function getAll(){
        return Process::get();
    }
}