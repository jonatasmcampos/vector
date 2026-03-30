<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $table = 'actions';
    protected $fillable = [
        'name',
        'description',
    ];
    public $timestamps = false;
}
