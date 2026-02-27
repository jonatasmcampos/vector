<?php

namespace App\Domain\ValueObjects;

use Exception;
use InvalidArgumentException;

final class CPF
{
    /**
     * Pode estar formatado ou não,
     * dependendo do método de criação
     */
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * Recebe CPF SEM pontuação
     * Ex: 12345678909
     * Armazena FORMATADO
     */
    public static function fromUnformatted(string $cpf): self
    {
        if (! self::isValid($cpf)) {
            throw new InvalidArgumentException('CPF inválido');
        }

        $formatted = self::format($cpf);

        return new self($formatted);
    }

    /**
     * Recebe CPF COM pontuação
     * Ex: 123.456.789-09
     * Armazena SEM pontuação
     */
    public static function fromFormatted(string $cpf): self
    {
        $digits = self::onlyNumbers($cpf);

        if (! self::isValid($digits)) {
            throw new Exception('CPF inválido');
        }

        return new self($digits);
    }

    /**
     * Retorna exatamente o valor armazenado
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * Comparação por valor
     */
    public function equals(CPF $other): bool
    {
        return $this->value === $other->value;
    }

    /**
     * ======================
     * MÉTODOS INTERNOS
     * ======================
     */

    private static function onlyNumbers(string $value): string
    {
        return preg_replace('/\D/', '', $value);
    }

    private static function format(string $cpf): string
    {
        return preg_replace(
            '/(\d{3})(\d{3})(\d{3})(\d{2})/',
            '$1.$2.$3-$4',
            $cpf
        );
    }

    private static function isValid(string $cpf): bool
    {
        if (! preg_match('/^\d{11}$/', $cpf)) {
            return false;
        }

        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $sum = 0;

            for ($i = 0; $i < $t; $i++) {
                $sum += $cpf[$i] * (($t + 1) - $i);
            }

            $digit = ((10 * $sum) % 11) % 10;

            if ($cpf[$t] != $digit) {
                return false;
            }
        }

        return true;
    }
}