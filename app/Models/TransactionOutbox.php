<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionOutbox extends Model
{
    protected $table = 'transaction_outboxes';  
    protected $fillable = [
        'payload',
        'header',
        'attempts',
        'received_at',
        'committed_at',
        'status_id',
        'last_error',
        'last_attempted_at',
        'processing_at',
    ];
    protected $casts = [
        'payload' => 'array',
        'header' => 'array',
        'received_at' => 'datetime',
        'committed_at' => 'datetime',
        'last_attempted_at' => 'datetime',
        'processing_at' => 'datetime',
    ];

    public function status(){
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
}
