<?php

declare(strict_types=1);

namespace App\Balancer\Strategy;

use App\Queue\IQueue;

/**
 * Class SmoothWeight
 *
 * @package App\Balancer\Strategy
 */
final class SmoothWeight implements IBalanceStrategy
{
    /**
     * @var Item[]
     */
    private array $items = [];

    public function add(IQueue $queue, int $weight): void
    {
        $item = new Item($queue, $weight);
        $this->items[] = $item;
    }
    public function next(): IQueue|null
    {
        return $this->nextWeighted();
    }

    public function removeAll(): void
    {
        $this->items = [];
    }

    public function reset(): void
    {
        foreach ($this->items as $item) {
            $item->effectiveWeight = $item->weight;
            $item->currentWeight = 0;
        }
    }

    /**
     * @return IQueue[]
     */
    public function all(): array
    {
        return \array_map(fn ($item) => $item->queue, $this->items);
    }

    public function nextWeighted(): IQueue|null
    {
        if (\count($this->items) === 0) {
            return null;
	    }

        if (\count($this->items) === 1) {
            return $this->items[0]->queue;
	    }

        return $this->nextSmoothWeighted();
    }

    public function nextSmoothWeighted(): IQueue|null
    {
        $total = 0;
        $bestItem = null;

        for ($i = 0; $i < \count($this->items); $i++) {
            $item = $this->items[$i];

            // Очереди с 0 месседжей пропускаем.
            if ($item->queue->count() === 0) {
                continue;
            }

            $item->currentWeight += $item->effectiveWeight;
            $total += $item->effectiveWeight;

            if ($item->effectiveWeight < $item->weight) {
                $item->effectiveWeight++;
            }

            if ($bestItem === null || $item->currentWeight > $item->effectiveWeight) {
                $bestItem = $item;
            }
        }

        if ($bestItem === null) {
            return null;
        }

        $bestItem->currentWeight -= $total;

        return $bestItem->queue;
    }
}
