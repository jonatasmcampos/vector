<?php

namespace App\Exceptions\Handlers;

use App\Domain\Contracts\Exceptions\ExceptionStrategyInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class NotFoundRouteStrategy implements ExceptionStrategyInterface
{
    public function supports(Throwable $exception): bool
    {
        return $exception instanceof NotFoundHttpException;
    }

    public function handle(Throwable $exception): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => 404,
            'success' => false,
            'message' => $exception->getMessage() ?: 'A rota acessada não existe no sistema.'
        ], 404);
    }
}
