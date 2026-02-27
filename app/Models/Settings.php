<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
        'group_name',
    ];

    public function scopeGroup(string $group)
    {
        return $this->where('group_name', $group);
    }

    public function value()
    {
        return self::castValue($this->value);
    }

    private static function castValue(string $value)
    {
        // Boolean
        if ($value === 'true') return true;
        if ($value === 'false') return false;

        // Integer
        if (ctype_digit($value)) {
            return (int) $value;
        }

        // Float
        if (is_numeric($value)) {
            return (float) $value;
        }

        // JSON
        if (self::isJson($value)) {
            return json_decode($value, true);
        }

        // String padrão
        return $value;
    }

    private static function isJson(string $value): bool
    {
        json_decode($value);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
