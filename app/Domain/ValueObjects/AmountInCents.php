<?php

namespace App\Domain\ValueObjects;

class AmountInCents{
    
    private int $amount;

    public function __construct(int $amount)
    {
        $this->validate($amount);
        $this->amount = $amount;   
    }

    private function validate(int $amount){
        if($amount < 0 ){
            throw new \Exception("O valor não pode ser negativo!", 400);            
        }
    }

    public static function fromInteger(int $amount): self{
        return new self($amount);
    }

    public static function fromString(string $amount): self{
        $amount = trim($amount);
        $amount_in_brl = (float) str_replace(['.', ','], ['', '.'], $amount);
        $amount_in_cents = (int) round($amount_in_brl * 100);
        return new self($amount_in_cents);
    }

    public function value(): int
    {
        return $this->amount;
    }

    public function toBRLMoney(): BRLMoney{
        return BRLMoney::fromInteger($this->amount);
    }

    public static function fromFloat(float $amount): self{
        $cents = (int) bcmul((string)$amount, "100", 0);
        return new self($cents);
    }

}