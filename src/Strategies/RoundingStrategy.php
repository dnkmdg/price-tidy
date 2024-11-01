<?php

namespace Dnkmdg\PriceTidy\Strategies;

abstract class RoundingStrategy
{
    abstract public function round(float $value): float;
}
