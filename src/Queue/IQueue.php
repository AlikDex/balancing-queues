<?php

namespace App\Queue;

interface IQueue
{
    /**
     * Retrieve an item from queue.
     *
     * @return mixed
     */
    public function dequeue(): mixed;

    /**
     * Adds new item to queue.
     *
     * @param mixed $value
     * @return void
     */
    public function enqueue(mixed $value): void;

    /**
     * Gets number of items.
     *
     * @return int
     */
    public function count(): int;
}
