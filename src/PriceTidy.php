<?php

namespace Dnkmdg\PriceTidy;

use Dnkmdg\PriceTidy\Strategies\RoundingStrategy;

class PriceTidy
{
    /**
     * Rounded price including VAT
     */
    public float $priceIncVat;

    /**
     * Rounded price excluding VAT
     */
    public float $priceExVat;

    /**
     * VAT calculated from the rounded price
     */
    public float $vat;

    /**
     * VAT calculated from the original price
     */
    public float $originalVat;

    /**
     * Whether the price has been rounded
     */
    public bool $hasRounded = false;

    /**
     * Create a new PriceTidy instance.
     *
     * @return void
     */
    public function __construct(
        // Original price before rounding
        public float $originalPrice,
        // VAT rate
        public ?float $vatRate = null,
        // Strategy for rounding
        public ?RoundingStrategy $strategy = null,
        // Whether the price includes VAT
        public bool $priceIncludesVat = false,
    ) {
        $this->setValues();
    }

    public function setValues(): void
    {
        $this->priceIncVat = $this->round();
        $this->priceExVat = $this->withoutVat();
        $this->vat = $this->getVat($this->priceIncVat);

        $originalPriceExVat = $this->priceIncludesVat ? $this->priceExVat : $this->originalPrice;

        $this->originalVat = $this->getVat($originalPriceExVat * $this->vatRate);

        if ($originalPriceExVat !== $this->priceExVat) {
            $this->hasRounded = true;
        }
    }

    /**
     * Set the rounding strategy.
     */
    public function setStrategy(RoundingStrategy $strategy): void
    {
        $this->strategy = $strategy;
        $this->setValues();
    }

    /**
     * Get the VAT amount.
     */
    public function getVat($price)
    {
        return round($price - ($price / $this->vatRate), 3);
    }

    /**
     * Round the price.
     */
    public function round(): float
    {
        if ($this->priceIncludesVat) {
            return $this->strategy->round($this->originalPrice);
        } else {
            return $this->strategy->round($this->originalPrice * $this->vatRate);
        }

    }

    /**
     * Get the price excluding VAT.
     */
    public function withoutVat(): float
    {
        if ($this->vatRate !== null && $this->vatRate != 0) {
            return $this->priceIncVat / $this->vatRate;
        }
    }

    /**
     * Create a new PriceTidy instance.
     */
    public static function create(
        float $originalPrice,
        float $vatRate,
        RoundingStrategy $strategy,
        bool $priceIncludesVat = false,
    ): PriceTidy {
        return new PriceTidy($originalPrice, $vatRate, $strategy, $priceIncludesVat);
    }

    /**
     * Create a new PriceTidy instance from a price including VAT.
     */
    public static function createFromIncVat(
        float $originalPrice,
        float $vatRate,
        RoundingStrategy $strategy,
    ): PriceTidy {
        return new PriceTidy($originalPrice, $vatRate, $strategy, true);
    }

    /**
     * Create a new PriceTidy instance from a price excluding VAT.
     */
    public static function createFromExVat(
        float $originalPrice,
        float $vatRate,
        RoundingStrategy $strategy,
    ): PriceTidy {
        return new PriceTidy($originalPrice, $vatRate, $strategy, false);
    }
}
