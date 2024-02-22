<?php

declare(strict_types=1);

namespace App\Balancer\Strategy;

use App\Queue\IQueue;

/**
 * Контейнер для очереди, содерджит саму очередь и веса для нее.
 * Нужен чтобы не завязываться на конкретную реализацию очереди.
 * Не добавлять в нее эти параметы.
 * При использовании дугой стратегии, напримерр раунд-робин, или рандом какой
 * веса не нужны.
 */
final class Item
{
    public int $currentWeight;

    public function __construct(
        public IQueue $queue,
        public int $weight = 1
    ) {
        $this->currentWeight = $weight;
    }
}
