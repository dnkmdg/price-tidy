# PriceTidy
![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/dnkmdg/price-tidy/php.yml?label=tests)
![GitHub Release](https://img.shields.io/github/v/release/dnkmdg/price-tidy)
![GitHub Downloads (all assets, all releases)](https://img.shields.io/github/downloads/dnkmdg/price-tidy/total?color=blue)



PriceTidy is a PHP library for seamless price rounding and adjustment using various rounding strategies.

## Installation

To install PriceTidy, you can use Composer:

```bash
composer require dnkmdg/price-tidy
```

## Usage

Here's a basic example of how to use PriceTidy:

```php
use Dnkmdg\PriceTidy\PriceTidy;
use Dnkmdg\PriceTidy\Strategies\RoundUpToNearestIntegerStrategy;

$priceTidy = new PriceTidy(10.5, 1.25, new RoundUpToNearestIntegerStrategy());
echo $priceTidy->priceIncVat; // Output: 14
```

## Rounding Strategies

PriceTidy supports multiple rounding strategies:

- `RoundUpToNearestIntegerStrategy`: Rounds up to the nearest integer.
- `RoundUpToNearestNineStrategy`: Rounds up to the nearest nine.
- `RoundUpToNearestTenStrategy`: Rounds up to the nearest ten.
- `RoundUpToNearestHundredStrategy`: Rounds up to the nearest hundred.
- `EuroStrategy`: Example of a custom rounding strategy.


## Example

```php
use Dnkmdg\PriceTidy\PriceTidy;
use Dnkmdg\PriceTidy\Strategies\RoundUpToNearestTenStrategy;

$priceTidy = new PriceTidy(10.5, 1.25, new RoundUpToNearestTenStrategy());
echo $priceTidy->priceIncVat; // Output: 20
```

## Custom Rounding Strategy

You can create your own custom rounding strategy by extending the `RoundingStrategy` abstract class and implementing the `round` method.

Here's an example of a custom rounding strategy that rounds to the nearest five:

```php
namespace Dnkmdg\PriceTidy\Strategies;

class RoundToNearestFiveStrategy extends RoundingStrategy
{
    public function round(float $value): float
    {
        return round($value / 5) * 5;
    }
}
```

To use this custom strategy with PriceTidy:

```php
use Dnkmdg\PriceTidy\PriceTidy;
use Dnkmdg\PriceTidy\Strategies\RoundToNearestFiveStrategy;

$priceTidy = new PriceTidy(10.5, 1.25, new RoundToNearestFiveStrategy());
echo $priceTidy->priceIncVat; // Output will be 15
```


## Running Tests

To run the tests, use PHPUnit:

```bash
vendor/bin/pest
```

## License

This project is licensed under the MIT License.

## Authors

- Daniel Källstrand Modig (daniel.modig@me.com)

## Contributing

Contributions are welcome! Please open an issue or submit a pull request.


This project is licensed under the MIT License.