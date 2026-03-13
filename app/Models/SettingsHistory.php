<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingsHistory extends Model
{
    protected $table = 'settings_histories';

    protected $fillable = [
        'key',
        'value',
        'group_name',
        'history_id'
    ];

    public function history()
    {
        return $this->belongsTo(History::class, 'history_id', 'id');
    }
}
