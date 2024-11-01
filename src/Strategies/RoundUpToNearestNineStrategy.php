<?php

namespace Dnkmdg\PriceTidy\Strategies;

class RoundUpToNearestNineStrategy extends RoundingStrategy
{
    public function round(float $amount): float
    {
        return ceil($amount / 10) * 10 - 1;
    }
}
