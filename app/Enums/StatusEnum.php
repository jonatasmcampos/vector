<?php

namespace App\Enums;

use Illuminate\Support\HtmlString;

enum StatusEnum: int
{
    case PENDING = 1;
    case CONFIRMED = 2;
    case PAID = 3;
    case CANCELLED = 4;

    public static function getDataToInsert(): array{
        return [
            [
                'id' => self::PENDING->value,
                'name' => 'Pendente',
                'description' => null,
            ],
            [
                'id' => self::CONFIRMED->value,
                'name' => 'Confirmado',
                'description' => null,
            ],
            [
                'id' => self::PAID->value,
                'name' => 'Pago',
                'description' => null,
            ],
            [
                'id' => self::CANCELLED->value,
                'name' => 'Cancelado',
                'description' => null,
            ]
        ];
    }

    public static function badge(int $status_id): HtmlString{
        return new HtmlString (match ($status_id) {
            1  => '<span class="badge bg-warning"> PENDENTE     </span>',
            2  => '<span class="badge bg-success"> CONFIRMADO   </span>',
            3  => '<span class="badge bg-success"> PAGO         </span>',
            4  => '<span class="badge bg-danger">  CANCELADO    </span>',
        });
    }
}