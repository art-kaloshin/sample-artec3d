<?php

interface PriceCalculatorInterface
{
    public function setEventAmount(int $amount): self;

    public function getPrice(): float;
}