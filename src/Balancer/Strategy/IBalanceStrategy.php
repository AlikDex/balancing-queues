<?php

namespace App\Balancer\Strategy;

use App\Queue\IQueue;

interface IBalanceStrategy
{
    public function add(IQueue $queue): void;

    public function next(): IQueue|null;

    public function removeAll(): void;

    public function reset(): void;
}
