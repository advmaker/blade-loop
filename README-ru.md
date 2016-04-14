# blade-loop

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Пакет вдохновленный проектом https://github.com/RobinRadic/blade-extensions, который по нашему мнению содержит много лишнего. Данный проект добавляет в Blade конструкции управления циклом, а так же @loop директиву для доступа к переменной как в [twig](http://twig.sensiolabs.org/doc/tags/for.html#the-loop-variable).

## Установка

С помощью Composer

``` bash
$ composer require advmaker/blade-loop
```

И добавить сервис провайдер в `config/app.php`

```
'providers' => [
    //...

    Advmaker\BladeLoop\BladeLoopServiceProvider::class,

    //...
]
```

## Описание
До версии v5.2.12 Blade не имел директив `@break` и `@continue` которые весьма удобны. Тем более что до v5.2.22 эти директивы не поддерживают условия. Данный пакет добавляет их в более старые версии.
 
И основное, это добавлена директива `@loop`, которая делает доступной внутри цикла переменную `$loop`, которая практически аналогична подобной в шаблонизаторе Twig. Таблица с описанием:

| Свойство          | Описание    |
|:------------------|:------------|
| $loop->index1     | Номер текущей итерации. (начиная с 1) |
| $loop->index      | Номер текущей итерации. (начиная с 0) |
| $loop->revindex1  | Число итераций до конца или номер итерации обратный отсчет. |
| $loop->revindex   | Номер итерации обратный отсчет. |
| $loop->first      | True на первой итерации. |
| $loop->last       | True на последней итерации. |
| $loop->length     | Число итераций или кол-во обходимых элементов. |
| $loop->parent     | Родительский цикл (при вложенных циклах) |

> Замечание: параметры `length`, `last`, `revindex1` и `revindex` доступны только при итерации массивов, или объектов реализующих интерфейс Countable.

## Пример использования

``` php
@loop($array as $key => $val)
    {{ $loop->index;}}        {{-- int, начинается с 0 --}}
    {{ $loop->index1; }}      {{-- int, начинается с 1 --}}
    {{ $loop->revindex; }}    {{-- int --}}
    {{ $loop->revindex1; }}   {{-- int --}}
    {{ $loop->first; }}       {{-- bool --}}
    {{ $loop->last; }}        {{-- bool --}}
    {{ $loop->even; }}        {{-- bool --}}
    {{ $loop->odd; }}         {{-- bool --}}
    {{ $loop->length; }}      {{-- int --}}

    @loop($val as $inner_key => $val)
        {{ $loop->parent->odd; }}
        {{ $loop->parent->index; }}
    @endloop  

    @break(false)

    @continue($loop->index === $loop->revindex)
@endloop
```

## Лицензия

Опубликовано под MIT License (MIT). Для подробной информации смотрите [Файл Лицензии](LICENSE.md).

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
