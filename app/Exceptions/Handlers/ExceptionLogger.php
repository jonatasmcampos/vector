<?php

namespace App\Exceptions\Handlers;

use Throwable;
use Illuminate\Support\Facades\Log;

class ExceptionLogger
{
    public function log(Throwable $exception): void
    {
        Log::error($exception->getMessage(), [
            '---- EXCEPTION' => $exception,
            '---- MESSAGE' => $exception->getMessage(),
            '---- FILE' => $exception->getFile(),
            '---- LINE' => $exception->getLine()
        ]);
    }
}
