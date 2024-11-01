<?php

namespace Dnkmdg\PriceTidy\Strategies;

class RoundUpToNearestIntegerStrategy extends RoundingStrategy
{
    /**
     * Round the given value to the nearest integer.
     */
    public function round(float $value): float
    {
        return ceil($value);
    }
}
