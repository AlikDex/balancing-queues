<?php

declare(strict_types=1);

namespace App\Queue;

use SplQueue;

/**
 * Class Queue
 *
 * @package App\Queue
 */
final class Queue extends SplQueue implements IQueue
{
    public readonly int $id;

    public function __construct() {
        $this->id = \random_int(0, 1000000000); // просто чтоб не задавать чеез констуктор или сеттер

        $this->setIteratorMode(static::IT_MODE_DELETE);
    }
}
