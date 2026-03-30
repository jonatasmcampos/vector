<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallmentType extends Model
{
    protected $table = 'installment_types';
    protected $fillable = [
        'name',
        'description',
    ];
    public $timestamps = false;
}
