<?php

namespace App\Exceptions\Handlers;

use App\Domain\Contracts\Exceptions\ExceptionStrategyInterface;
use Throwable;

class DefaultExceptionStrategy implements ExceptionStrategyInterface
{
    public function supports(Throwable $exception): bool
    {
        return true;
    }

    public function handle(Throwable $exception): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => 500,
            'success' => false,
            'message' => $exception->getMessage() ?: 'Ocorreu um erro interno no servidor.',
            'file' => $exception->getFile(),
            'line' => $exception->getLine()
        ], 500);
    }
}
