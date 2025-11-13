<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditUsageType extends Model
{
    protected $table = 'credit_usage_types';
    protected $fillable = [
        'name',
        'description',
    ];
    public $timestamps = false;
}
