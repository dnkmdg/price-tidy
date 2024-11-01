<?php

use Dnkmdg\PriceTidy\PriceTidy;
use Dnkmdg\PriceTidy\Strategies\EuroStrategy;
use Dnkmdg\PriceTidy\Strategies\RoundUpToNearestHundredStrategy;
use Dnkmdg\PriceTidy\Strategies\RoundUpToNearestIntegerStrategy;
use Dnkmdg\PriceTidy\Strategies\RoundUpToNearestNineStrategy;
use Dnkmdg\PriceTidy\Strategies\RoundUpToNearestTenStrategy;

describe('RoundingTest', function () {
    it('should round a number to the nearest integer', function () {
        $rounding = new PriceTidy(10.5, 1.25, new RoundUpToNearestIntegerStrategy);

        expect($rounding->priceIncVat)->toEqual(14);
    });

    it('should round a number to the nearest ten', function () {
        $rounding = new PriceTidy(10.5, 1.25, new RoundUpToNearestTenStrategy);

        expect($rounding->priceIncVat)->toEqual(20);
    });

    it('should round a number to the nearest hundred', function () {
        $rounding = new PriceTidy(102049, 1.25, new RoundUpToNearestHundredStrategy, true);

        expect($rounding->priceIncVat)->toEqual(102100);
    });

    it('should return the correct vat in relation to the rounded price', function () {
        $rounding = PriceTidy::create(10, 1.25, new RoundUpToNearestIntegerStrategy, false);

        expect($rounding->vat)->toEqual(2.6);
        expect($rounding->originalVat)->toEqual(2.5);
        expect($rounding->priceIncVat)->toEqual(13);
        expect($rounding->priceExVat)->toEqual(10.4);
    });

    it('should return the correct vat in relation to the rounded price when price includes vat', function () {
        $rounding = PriceTidy::create(10, 1.25, new RoundUpToNearestIntegerStrategy, true);

        expect($rounding->vat)->toEqual(2);
        expect($rounding->originalVat)->toEqual(2);
        expect($rounding->priceIncVat)->toEqual(10);
        expect($rounding->priceExVat)->toEqual(8);
    });

    it('should set a new rounding strategy', function () {
        $rounding = new PriceTidy(10.5, 1.25, new RoundUpToNearestIntegerStrategy);

        expect($rounding->priceIncVat)->toEqual(14);

        $rounding->setStrategy(new RoundUpToNearestTenStrategy);

        expect($rounding->priceIncVat)->toEqual(20);
    });

    it('should create a new rounding for ex vat', function () {
        $rounding = PriceTidy::createFromExVat(10, 1.25, new RoundUpToNearestIntegerStrategy);

        expect($rounding->priceIncVat)->toEqual(13);
        expect($rounding->priceExVat)->toEqual(10.4);
        expect($rounding->priceIncludesVat)->toBe(false);
    });

    it('should create a new rounding for inc vat', function () {
        $rounding = PriceTidy::createFromIncVat(10, 1.25, new RoundUpToNearestIntegerStrategy);

        expect($rounding->priceIncVat)->toEqual(10);
        expect($rounding->priceExVat)->toEqual(8);
        expect($rounding->priceIncludesVat)->toBe(true);
        expect($rounding->hasRounded)->toBeFalse();
    });

    it('should round up to the nearest 9', function () {
        $rounding = new PriceTidy(10.5, 1.25, new RoundUpToNearestNineStrategy);
        $rounding2 = PriceTidy::createFromIncVat(41, 1.25, new RoundUpToNearestNineStrategy);

        expect($rounding->priceIncVat)->toEqual(19);
        expect($rounding2->priceIncVat)->toEqual(49);
        expect($rounding->hasRounded)->toBeTrue();
    });

    it('should round up to nearest int above 20 and to two decimals below 20', function () {
        $rounding = new PriceTidy(9.35, 1.25, new EuroStrategy, true);
        $rounding2 = new PriceTidy(9.91, 1.25, new EuroStrategy, true);
        $rounding3 = new PriceTidy(10.5, 1.25, new EuroStrategy, true);
        $rounding4 = new PriceTidy(3, 1.25, new EuroStrategy, true);
        $rounding5 = new PriceTidy(7.49, 1.25, new EuroStrategy, true);
        $rounding6 = new PriceTidy(7.12, 1.25, new EuroStrategy, true);
        $rounding7 = new PriceTidy(6.6, 1.25, new EuroStrategy, true);
        $rounding8 = new PriceTidy(6, 1.25, new EuroStrategy, true);
        $rounding9 = new PriceTidy(20, 1.25, new EuroStrategy, true);
        $rounding10 = new PriceTidy(20.5, 1.25, new EuroStrategy, true);
        $rounding11 = new PriceTidy(6.99, 1.25, new EuroStrategy, true);
        $rounding12 = new PriceTidy(17.81, 1.25, new EuroStrategy, true);
        $rounding13 = new PriceTidy(17.89, 1.25, new EuroStrategy, true);
        $rounding14 = new PriceTidy(10, 1.25, new EuroStrategy, true);

        expect($rounding->priceIncVat)->toEqual(9.39);
        expect($rounding2->priceIncVat)->toEqual(9.99);
        expect($rounding3->priceIncVat)->toEqual(10.59);
        expect($rounding4->priceIncVat)->toEqual(3.09);
        expect($rounding5->priceIncVat)->toEqual(7.49);
        expect($rounding6->priceIncVat)->toEqual(7.19);
        expect($rounding7->priceIncVat)->toEqual(6.69);
        expect($rounding8->priceIncVat)->toEqual(6.09);
        expect($rounding9->priceIncVat)->toEqual(20);
        expect($rounding10->priceIncVat)->toEqual(21);
        expect($rounding11->priceIncVat)->toEqual(6.99);
        expect($rounding12->priceIncVat)->toEqual(17.89);
        expect($rounding13->priceIncVat)->toEqual(17.89);
        expect($rounding14->priceIncVat)->toEqual(10.09);
    });
});
