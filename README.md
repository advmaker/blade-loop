# blade-loop

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This package inspired (more appropriate word: "copied") from https://github.com/RobinRadic/blade-extensions but instead of doing multiple things with
blade engine (ie: markdown parsing, multiple extensions, etc) it just adds @loop directive to support twig-like loop.

## Install

Via Composer

``` bash
$ composer require advmaker/blade-loop
```

## Explanation
By default, blade doesn't have `@break` and `@continue` which are useful to have. So that's included.
 
Furthermore, the `$loop` variable is introduced inside loops, (almost) exactly like Twig. Description table:

| Variable | Description |
|:---------|:------------|
| $loop->index1 | The current iteration of the loop. (1 indexed) |
| $loop->index | The current iteration of the loop. (0 indexed) |
| $loop->revindex1 | The number of iterations from the end of the loop (1 indexed) |
| $loop->revindex | The number of iterations from the end of the loop (0 indexed) |
| $loop->first | 	True if first iteration |
| $loop->last | True if last iteration |
| $loop->length | The number of items in the sequence |
| $loop->parent | The parent context |

## Usage

``` php
@loop($array as $key => $val)
    $loop->index;       // int, zero based
    $loop->index1;      // int, starts at 1
    $loop->revindex;    // int
    $loop->revindex1;   // int
    $loop->first;       // bool
    $loop->last;        // bool
    $loop->even;        // bool
    $loop->odd;         // bool
    $loop->length;      // int

    @loop($val as $inner_key => $val)
        $loop->parent->odd;
        $loop->parent->index;
    @endloop  
    
    @break

    @continue
@endloop
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email e.zubarev@advmaker.net instead of using the issue tracker.

## Credits

- [advmaker][link-author]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/advmaker/blade-loop.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/advmaker/blade-loop/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/advmaker/blade-loop.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/advmaker/blade-loop.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/advmaker/blade-loop.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/advmaker/blade-loop
[link-travis]: https://travis-ci.org/advmaker/blade-loop
[link-scrutinizer]: https://scrutinizer-ci.com/g/advmaker/blade-loop/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/advmaker/blade-loop
[link-downloads]: https://packagist.org/packages/advmaker/blade-loop
[link-author]: https://github.com/advmaker
