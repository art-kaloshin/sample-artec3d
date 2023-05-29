<?php

class OfflineCalculator extends PriceCalculator implements PriceCalculatorInterface
{
    const ALL_DAY_PRICE = 33000;
    const EVENT_PRICE = 4000;
    const DISCOUNT = 100;

    public function getPrice(): float
    {
        if (isset($amount)) {
            $basePrice = self::EVENT_PRICE;
            $price = 0;
            for ($x = 0; $x < $this->amount; $x++) {
                $price += $basePrice;
                $basePrice - self::DISCOUNT > 0 && $basePrice -= self::DISCOUNT;
            }

            return $price;
        }
        return self::ALL_DAY_PRICE;
    }
}