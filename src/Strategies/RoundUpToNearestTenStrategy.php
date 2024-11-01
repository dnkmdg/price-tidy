<?php

namespace Dnkmdg\PriceTidy\Strategies;

class RoundUpToNearestTenStrategy extends RoundingStrategy
{
    /**
     * Round the given value to the nearest integer.
     */
    public function round(float $value): float
    {
        return ceil($value / 10) * 10;
    }
}
