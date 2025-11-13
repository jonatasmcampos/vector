<?php

namespace App\Domain\Contracts\Exceptions;

use Throwable;

interface ExceptionStrategyInterface
{
    public function supports(Throwable $exception): bool;
    public function handle(Throwable $exception): \Illuminate\Http\JsonResponse;
}
