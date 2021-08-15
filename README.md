# Veil

[![PHP Unit Tests](https://github.com/adrianmejias/veil/actions/workflows/tests.yml/badge.svg)](https://github.com/adrianmejias/veil/actions/workflows/tests.yml) ![Downloads](https://img.shields.io/packagist/dt/adrianmejias/veil) ![Packagist](https://img.shields.io/packagist/v/adrianmejias/veil) ![License](https://img.shields.io/packagist/l/adrianmejias/veil) ![Liberapay](https://img.shields.io/liberapay/patrons/adrianmejias.svg?logo=liberapay)

Autoloader for custom class instances.

# Installation

`composer require adrianmejias/veil`

# Basic Usage

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use AdrianMejias\Veil\Veil;

$veil = new Veil();
$veil->register();
$veil->add([
    'Foo' => Veils\FooVeil::class,
]);
// $veil->add('Foo', Veils\FooVeil::class);
// composer autoload psr-4 -> "Veils\\": "src/Veils/",

echo 'Hello, ' . \Foo::bar() . '!';
// Foo->bar() -> return 'world'
```

Expected Output:
```html
Hello, world!
```

# Todo

- [ ] Add to packagist repo
- [x] Add unit tests
- [ ] Add documentation for open source contributations
- [ ] Add GitHub Action for unit tests
- [ ] Add requirements to README.md
- [ ] Add API listing to README.md

## Contributing

Thank you for considering contributing to Testbench! You can read the contribution guide [here](.github/CONTRIBUTING.md).

## Code of Conduct

In order to ensure that the community is welcoming to all, please review and abide by the [Code of Conduct](.github/CODE_OF_CONDUCT.md).

## License

Testbench is open-sourced software licensed under the [MIT license](LICENSE.md).
