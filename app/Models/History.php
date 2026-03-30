<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'histories';
    protected $fillable = [
        'date',
        'observation',
        'user_id',
        'action_id',
        'process_id',
        'contract_id'
    ];
    protected $casts = [
        'date' => 'datetime',
        'user_id' => 'integer',
        'action_id' => 'integer',
        'process_id' => 'integer',
        'contract_id' => 'integer',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function action(){
        return $this->belongsTo(Action::class, 'action_id', 'id');
    }

    public function process(){
        return $this->belongsTo(Process::class, 'process_id', 'id');
    }

    public function contract(){
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function installment_histories()
    {
        return $this->hasMany(InstallmentHistory::class);
    }
}
