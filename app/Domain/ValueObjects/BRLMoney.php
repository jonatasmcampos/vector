<?php

namespace App\Domain\ValueObjects;

class BRLMoney{
    private float $amount;

    public function __construct(float $amount)
    {
        $this->validate($amount);
        $this->amount = $amount;   
    }

    private function validate(float $amount){
        if($amount < 0 ){
            throw new \Exception("O valor não pode ser negativo!", 400);            
        }
    }

    public function value(): float
    {
        return $this->amount;
    }

    public static function fromFloat(float $amount): self
    {
        return new self($amount);
    }

    public static function fromInteger(int $amount): self{
        return new self(($amount / 100));
    }

    public function toString(): string{
        return number_format($this->amount, 2, ',', '.');
    }

}