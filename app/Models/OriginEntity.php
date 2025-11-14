<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OriginEntity extends Model
{
    protected $table = 'origin_entities';
    protected $fillable = [
        'name',
        'description',
    ];
    public $timestamps = false;
}
