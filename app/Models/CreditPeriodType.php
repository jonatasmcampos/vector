<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditPeriodType extends Model
{
    protected $table = 'credit_period_types';
    protected $fillable = [
        'name',
        'description',
    ];
    public $timestamps = false;
}
