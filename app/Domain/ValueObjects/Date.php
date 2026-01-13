<?php

namespace App\Domain\ValueObjects;

use Carbon\Carbon;

final class Date
{
    private Carbon $value;

    public function __construct(Carbon $date)
    {
        $this->value = $date;
    }

    /**
     * Cria a partir de um Carbon.
     */
    public static function fromCarbon(Carbon $date): self
    {
        return new self($date);
    }

    /**
     * Cria a partir de string (YYYY-MM-DD, YYYY-MM-DD HH:MM:SS etc.).
     */
    public static function fromString(string $date): self
    {
        try {
            $carbon = Carbon::parse($date);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException("A data informada é inválida.");
        }

        return new self($carbon);
    }

    /**
     * Cria a partir de timestamp (int).
     */
    public static function fromTimestamp(int $timestamp): self
    {
        return new self(Carbon::createFromTimestamp($timestamp));
    }

    /**
     * Retorna a data como Carbon.
     */
    public function value(): Carbon
    {
        return $this->value;
    }

    /**
     * Formata a data.
     */
    public function format(string $pattern = 'Y-m-d'): string
    {
        return $this->value->format($pattern);
    }

    /**
     * Retorna como string padrão ISO (bom para APIs).
     */
    public function toIsoString(): string
    {
        return $this->value->toIso8601String();
    }

    /**
     * Retorna timestamp.
     */
    public function timestamp(): int
    {
        return $this->value->timestamp;
    }
}
