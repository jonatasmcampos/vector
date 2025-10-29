<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contracts';
    protected $fillable = [
        'name',
        'description',
        'contractor',
        'contract_master_cod',
        'code',
        'active'
    ];
    
    protected function casts(): array
    {
        return [
            'contract_master_cod' => 'integer',
            'active' => 'boolean'
        ];
    }
}
