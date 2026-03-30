<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditModality extends Model
{
    protected $table = 'credit_modalities';
    protected $fillable = [
        'name',
        'description',
    ];
    public $timestamps = false;
}
