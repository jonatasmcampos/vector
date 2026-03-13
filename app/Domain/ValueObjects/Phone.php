<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class Phone
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
     * Recebe APENAS números
     * Ex:
     * 11987654321 (celular)
     * 1132654321  (fixo)
     *
     * Armazena FORMATADO
     */
    public static function fromUnformatted(string $phone): self
    {
        if (! self::isValid($phone)) {
            throw new InvalidArgumentException('Telefone inválido');
        }

        $formatted = self::format($phone);

        return new self($formatted);
    }

    /**
     * Recebe telefone FORMATADO
     * Ex:
     * (11) 98765-4321
     * (11) 3265-4321
     *
     * Armazena SOMENTE NÚMEROS
     */
    public static function fromFormatted(string $phone): self
    {
        $digits = self::onlyNumbers($phone);

        if (! self::isValid($digits)) {
            throw new InvalidArgumentException('Telefone inválido');
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
    public function equals(Phone $other): bool
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

    private static function isValid(string $phone): bool
    {
        // Deve ter 10 (fixo) ou 11 (celular) dígitos
        return preg_match('/^\d{10,11}$/', $phone) === 1;
    }

    private static function format(string $phone): string
    {
        $ddd = substr($phone, 0, 2);
        $number = substr($phone, 2);

        // Celular (9 dígitos)
        if (strlen($number) === 9) {
            return sprintf(
                '(%s) %s-%s',
                $ddd,
                substr($number, 0, 5),
                substr($number, 5)
            );
        }

        // Fixo (8 dígitos)
        return sprintf(
            '(%s) %s-%s',
            $ddd,
            substr($number, 0, 4),
            substr($number, 4)
        );
    }
}
