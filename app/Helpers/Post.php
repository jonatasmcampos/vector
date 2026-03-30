<?php

namespace App\Helpers;

use Illuminate\Support\Fluent;

class Post
{

    public static function anti_injection($sql, $scape = true)
    {
        $pattern = "/( from |select|insert|delete|update|1=1|where|drop table|show tables|#|\*|--|\\\\)/i";
        $sql = preg_replace($pattern, '', $sql);
        $sql = trim($sql);
        if ($scape == true) {
            $sql = addslashes($sql);
        }
        return $sql;
    }

    public static function anti_injection_array($requestAll)
    {
        $parans = [];
        foreach ($requestAll as $key => $value) {
            if (is_array($value)) {
                $parans[$key] = self::anti_injection_array($value);
            } else {
                $parans[$key] = Post::anti_injection($value);
            }
        }
        return $parans;
    }

    public static function anti_injection_yajra(array $requestAll, ?callable $callback = null): Fluent
    {
        $params = self::anti_injection_array($requestAll);
        $params['columns'] = array_values(array_filter($params['columns'], fn($col) => $col['data'] !== 'action'));
        $data = array_map(fn($col) => $callback ? $callback([
            'value'  => $col['search']['value'],
            'column' => $col['data'],
        ]) : [
            'value'  => $col['search']['value'],
            'column' => $col['data'],
        ], $params['columns']);
        if (!empty($params['search']['value'])) {
            $data['search'] = $params['search']['value'];
        }
        return new Fluent($data);
    }
}
