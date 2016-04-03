<?php

namespace Advmaker\BladeLoop;

class LoopFactory
{

    /**
     * The stack of Loop instances
     *
     * @var Loop[] $stack
     */
    protected $stack = [];

    /**
     * Creates a new loop with the given array and adds it to the stack
     *
     * @param array $items The array that will be iterated
     */
    public function newLoop($items)
    {
        $this->addLoopStack(new Loop($this, $items));
    }

    /**
     * Adds a Loop to the stack
     *
     * @param Loop $stackItem
     */
    protected function addLoopStack(Loop $stackItem)
    {
        // Check stack for parent loop to register it with this loop
        if (count($this->stack) > 0) {
            $stackItem->setParentLoop(last($this->stack));
        }

        array_push($this->stack, $stackItem);
    }

    /**
     * Returns the stack
     *
     * @return array
     */
    public function getStack()
    {
        return $this->stack;
    }

    /**
     * getLastStack method
     *
     * @return Loop
     */
    public function getLastStack()
    {
        return end($this->stack);
    }

    /**
     * Resets the stack
     */
    public function reset()
    {
        $this->stack = [];
    }

    /**
     * To be called first inside the foreach loop. Returns the current loop
     *
     * @return Loop $current The current loop data
     */
    public function loop()
    {
        $current = end($this->stack);
        $current->before();

        return $current;
    }

    /**
     * To be called before the end of the loop
     */
    public function looped()
    {
        if (!empty($this->stack)) {
            end($this->stack)->after();
        }
    }

    /**
     * Should be called after the loop has finished
     *
     * @param $loop
     */
    public function endLoop(&$loop)
    {
        array_pop($this->stack);
        if (count($this->stack) > 0) {
            // This loop was inside another loop. We persist the loop variable and assign back the parent loop
            $loop = end($this->stack);
        } else {
            // This loop was not inside another loop. We remove the var
            $loop = null;
        }
    }
}
