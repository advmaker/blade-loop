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
     * The parent loop, if any
     *
     * @var Loop
     */
    protected $parentLoop;

    protected $loopFactory;

    /**
     * Sets the parent loop
     *
     * @param Loop $parentLoop
     */
    public function setParentLoop(Loop $parentLoop)
    {
        $this->parentLoop = $parentLoop;
        $this->data['parent'] = $parentLoop;
    }

    /**
     * Returns the full loop stack of the LoopFactory
     *
     * @return array
     */
    public function getLoopStack()
    {
        return $this->loopFactory->getStack();
    }

    /**
     * Resets the loop stack of the LoopFactory
     */
    public function resetLoopStack()
    {
        $this->loopFactory->reset();
    }

    /**
     * Instantiates the class
     *
     * @param array $items The array that's being iterated
     */
    public function __construct(LoopFactory $loopFactory, $items)
    {
        $this->loopFactory = $loopFactory;
        $this->setItems($items);
    }

    /**
     * Sets the array to monitor
     *
     * @param array $items The array that's being iterated
     */
    public function setItems($items)
    {
        $this->items = $items;
        $total = count($items);
        $this->data = [
            'index1'    => 1,
            'index'     => 0,
            'revindex1' => $total,
            'revindex'  => $total - 1,
            'first'     => true,
            'last'      => false,
            'odd'       => false,
            'even'      => true,
            'length'    => $total
        ];
    }

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
    public function before()
    {
        if ($this->data['index'] % 2 == 0) {
            $this->data['odd'] = false;
            $this->data['even'] = true;
        } else {
            $this->data['odd'] = true;
            $this->data['even'] = false;
        }
        if ($this->data['index'] == 0) {
            $this->data['first'] = true;
        } else {
            $this->data['first'] = false;
        }
        if ($this->data['revindex'] == 0) {
            $this->data['last'] = true;
        } else {
            $this->data['last'] = false;
        }
    }

    /**
     * To be called last in a loop after everything else
     */
    public function after()
    {
        $this->data['index']++;
        $this->data['index1']++;
        $this->data['revindex']--;
        $this->data['revindex1']--;
    }
}
