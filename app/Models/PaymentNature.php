<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentNature extends Model
{
    protected $table = 'payment_natures';
    protected $fillable = [
        'name',
        'description',
    ];
    public $timestamps = false;
}
