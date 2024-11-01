<?php

namespace Dnkmdg\PriceTidy\Strategies;

class EuroStrategy extends RoundingStrategy
{
    /**
     * Round the given value to the nearest integer if the value is greater than 10.
     * If the value is less than 10, round the value to the nearest second precision 9.
     * If the value is even, add 0.09 to the value.
     *
     * @param  float  $value  The value to be rounded.
     * @return int The rounded integer value.
     */
    public function round(float $value): float
    {
        // If the value is equal to, or greater than 20, round the value to the nearest integer.
        if ($value >= 20) {
            return ceil($value);
        }

        // If the value already ends with 9, return the value.
        if (substr((string) ($value * 10), -1) === '9') {
            return $value;
        }

        // Round the value to the nearest second precision 9.
        // Example: 3.0 * 10 = 30, 30 / 10 = 3, 3 - 0.01 = 2.99
        $roundedValue = ceil($value * 10) / 10 - 0.01;

        // Get the maximum between the original value and the rounded value to ensure we don't lower the value.
        $maxValue = max($value, $roundedValue);
        $maxValue = number_format($maxValue, 2);

        // If the value * 10 is even, add 0.09 to the value.
        // Example: 3.0 * 10 = 30, 30 % 2 = 0 => 3.0 + 0.09 = 3.09
        if (substr((string) $maxValue, -1) == '0') {
            $maxValue += 0.09;
        }

        // Return the rounded value.
        return round($maxValue, 2);
    }
}
