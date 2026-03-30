<?php

namespace App\Exceptions\Handlers;

use App\Domain\Contracts\Exceptions\ExceptionStrategyInterface;
use Illuminate\Validation\ValidationException;
use Throwable;

class ValidationExceptionStrategy implements ExceptionStrategyInterface
{
    public function supports(Throwable $exception): bool
    {
        return $exception instanceof ValidationException;
    }

    public function handle(Throwable $exception): \Illuminate\Http\JsonResponse
    {
        /** @var ValidationException $exception */
        $errors = $exception->validator->errors()->all();

        return response()->json([
            'status' => 422,
            'success' => false,
            'message' => $errors
        ], 422);
    }
}
