<?php

namespace Advmaker\BladeLoop\Support;

use Countable;
use IteratorAggregate;
use Traversable;

class Foo implements IteratorAggregate, Countable
{
    /**
     * @var array
     */
    private $arr;

    /**
     * Foo constructor.
     * @param array $arr
     */
    public function __construct(array $arr)
    {
        $this->arr = $arr;
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->arr);
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->arr);
    }
}
