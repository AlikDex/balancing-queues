<?php

namespace App\Balancer\Strategy;

use App\Queue\IQueue;

interface WeightStrategy
{
    public function add(IQueue $queue, int $weight): void;

    public function next(): IQueue|null;

    public function removeAll(): void;

    public function reset(): void;
}
