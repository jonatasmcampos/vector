<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallmentAmountType extends Model
{
    protected $table = 'installment_amount_types';
    protected $fillable = [
        'name',
        'description',
    ];
    public $timestamps = false;
}
