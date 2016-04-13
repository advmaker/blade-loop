<?php

namespace Advmaker\BladeLoop;

class Loop
{
    /**
     * The array that is being iterated
     *
     * @var array
     */
    protected $items = [];

    /**
     * The data for the current $loop item
     *
     * @var array
     */
    protected $data;

    /**
     * Instantiates the class
     *
     * @param array $items The array that's being iterated
     */
    public function __construct($items)
    {
        $this->items = $items;
        $this->init($items);
    }

    /**
     * Sets the array to monitor
     *
     * @param array $items The array that's being iterated
     */
    protected function init($items)
    {
        $total = count($items);
        $this->data = [
            'index'     => -1,
            'revindex'  => $total,
            'length'    => $total
        ];
    }

    /**
     * Sets the parent loop
     *
     * @param Loop $parentLoop
     */
    public function setParentLoop(Loop $parentLoop)
    {
        $this->data['parent'] = $parentLoop;
    }

    /**
     * Return array that must be iterated.
     *
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Magic method to access the loop data properties
     *
     * @param $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->data[$key];
    }

    /**
     * To be called first in a loop before anything else
     */
    public function loop()
    {
        $this->data['index']++;
        $this->data['index1'] = $this->data['index'] + 1;
        $this->data['revindex']--;
        $this->data['revindex1'] = $this->data['revindex'] + 1;

        $this->data['even'] = $this->data['index'] % 2 === 0;
        $this->data['odd'] = ! $this->data['even'];

        $this->data['first'] = $this->data['index'] === 0;
        $this->data['last'] = $this->data['revindex'] === 0;
    }
}
