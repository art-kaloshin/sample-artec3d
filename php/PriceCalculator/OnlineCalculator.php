<?php

class OnlineCalculator extends PriceCalculator implements PriceCalculatorInterface
{
    const ALL_DAY_PRICE = 22000;
    const EVENT_PRICE_1 = 2100;
    const EVENT_PRICE_2 = 2200;

    public function getPrice(): float
    {
        if (isset($amount)) {
            $price = 0;
            for ($x = 0; $x < $this->amount; $x++) {
                $price += ($x % 2 == 0) ? self::EVENT_PRICE_1 : self::EVENT_PRICE_2;
            }

            return $price;
        }
        return self::ALL_DAY_PRICE;
    }
}