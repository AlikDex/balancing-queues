<?php

declare(strict_types=1);

namespace App\Balancer;

use App\Balancer\Strategy\SmoothBalance;
use App\Balancer\Strategy\BalanceStrategy;

/**
 * Балансер очередей, возможно несколько стратегий.
 * В данном случае реализована только одна. Но есть контреат и на другие реализации.
 */
final class Balancer
{
    public function __construct(
        private readonly BalanceStrategy $strategy,
        private readonly int             $capacity = 10
    ) {}

    public function run(): void
    {
        while (true) {
            $batch = $this->getBatch();

            $this->handle($batch);

            if (\count($batch) === 0) {
                \sleep(1);
            }
        }
    }

    private function getBatch(): array
    {
        $messages = [];

        for ($i = 0; $i < $this->capacity; $i++) {
            $queue = $this->strategy->next();

            if ($queue === null) {
                break;
            }

            $messages[] = $queue->dequeue();
        }

        return $messages;
    }

    private function handle(array $batch): void
    {
        $messagesNum = \count($batch);

        echo "Handled {$messagesNum}:\n";

        foreach ($batch as $message) {
            echo " > {$message}\n";
        }
    }
}
