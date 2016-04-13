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
     * @return Loop
     */
    public function newLoop($items)
    {
        $loop = new Loop($items);

        // Check stack for parent loop to register it with this loop
        if (count($this->stack) > 0) {
            $loop->setParentLoop(last($this->stack));
        }

        array_push($this->stack, $loop);

        return $loop;
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

    /**
     * To be called first inside the foreach loop. Returns the current loop
     *
     * @return Loop $current The current loop data
     */
    public function loop()
    {
        $current = end($this->stack);
        $current->loop();

        return $current;
    }
}
