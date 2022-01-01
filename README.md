# Veil

[![security](https://github.com/adrianmejias/veil/actions/workflows/security.yml/badge.svg)](https://github.com/adrianmejias/veil/actions/workflows/security.yml) [![tests](https://github.com/adrianmejias/veil/actions/workflows/tests.yml/badge.svg)](https://github.com/adrianmejias/veil/actions/workflows/tests.yml) [![PHPStan](https://github.com/adrianmejias/veil/actions/workflows/phpstan.yml/badge.svg)](https://github.com/adrianmejias/veil/actions/workflows/phpstan.yml) [![PHP CS Fixer](https://github.com/adrianmejias/veil/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/adrianmejias/veil/actions/workflows/php-cs-fixer.yml) [![StyleCI](https://github.styleci.io/repos/394644917/shield?branch=main)](https://github.styleci.io/repos/394644917?branch=main) [![Build Status](https://travis-ci.com/adrianmejias/veil.svg?branch=main)](https://travis-ci.com/adrianmejias/veil) [![codecov](https://codecov.io/gh/adrianmejias/veil/branch/main/graph/badge.svg?token=P087FQPJ65)](https://codecov.io/gh/adrianmejias/veil) ![Downloads](https://img.shields.io/packagist/dt/adrianmejias/veil) ![Packagist](https://img.shields.io/packagist/v/adrianmejias/veil) ![License](https://img.shields.io/packagist/l/adrianmejias/veil) ![Liberapay](https://img.shields.io/liberapay/patrons/adrianmejias.svg?logo=liberapay)

Autoloader for custom class instances.

## Installation

This version supports PHP 8.0. You can install the package via composer:

`composer require adrianmejias/veil`

## Usage

### Example
```php
<?php

require __DIR__ . '/vendor/autoload.php';

use AdrianMejias\Veil\Veil;

$veil = new Veil();
$veil->register();

// An example when setting up a flolder and composer psr-4
// autoload is setup as: "Veils\\": "src/Veils/"
$veil->add([
    'Foo' => Veils\FooVeil::class, // The alias name and abstract class to alias against.
]);
// $veil->add('Foo', Veils\FooVeil::class);

// An example if the bar method in the Foo class returned 'world'
echo 'Hello, ' . \Foo::bar() . '!';
// use Foo;
// ...
// echo 'Hello, ' . Foo::bar() . '!';
```

Expected Output:
```html
Hello, world!
```

## Testing

`composer test`

## Todo

- [x] Add to packagist repo
- [x] Add unit tests
- [x] Add documentation for open source contributations
- [x] Add GitHub Action for unit tests
- [ ] Add more unit test coverages
- [ ] Add more documentation to README.md
- [ ] Add API listing to README.md

## Contributing

Thank you for considering contributing to Veil! You can read the contribution guide [here](.github/CONTRIBUTING.md).

## Code of Conduct

In order to ensure that the community is welcoming to all, please review and abide by the [Code of Conduct](.github/CODE_OF_CONDUCT.md).

## Security Vulnerabilities

Please see the [security file](SECURITY.md) for more information.

## License

The MIT License (MIT). Please see the [license file](LICENSE.md) for more information.
