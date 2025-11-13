<?php

namespace App\Exceptions;

use App\Domain\Contracts\Exceptions\ExceptionStrategyInterface;
use App\Exceptions\Handlers\ValidationExceptionStrategy;
use App\Exceptions\Handlers\DefaultExceptionStrategy;
use App\Exceptions\Handlers\NotFoundRouteStrategy;
use Throwable;

class ExceptionFactory
{
    /** @var ExceptionStrategyInterface[] */
    private array $strategies;

    public function __construct()
    {
        $this->strategies = [
            new ValidationExceptionStrategy(),
            new NotFoundRouteStrategy(),
            new DefaultExceptionStrategy()
        ];
    }

    public function make(Throwable $exception): ExceptionStrategyInterface
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($exception)) {
                return $strategy;
            }
        }

        return new DefaultExceptionStrategy();
    }
}
