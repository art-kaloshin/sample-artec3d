<?php

abstract class PriceCalculator implements PriceCalculatorInterface
{

    protected int $amount;

    public function setEventAmount(int $amount): PriceCalculatorInterface
    {
        $this->amount = $amount;
        return $this;
    }

    abstract public function getPrice(): float;
}