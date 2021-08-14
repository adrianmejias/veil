# Veil

![Downloads](https://img.shields.io/packagist/dt/adrianmejias/veil) ![Packagist](https://img.shields.io/packagist/v/adrianmejias/veil) ![License](https://img.shields.io/packagist/l/adrianmejias/veil)

Autoloader for custom class instances.

# Requirements

TBD

# Basic Usage

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use AdrianMejias\Veil;

$veil = new Veil();
$veil->register();
$veil->add([
    'Foo' => Veils\FooVeil::class,
]);
// $veil->add('Foo', Veils\FooVeil::class);

echo 'Hello, ' . Foo::bar() . '!';
// Foo->bar() return 'world'
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
