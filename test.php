<?php

use App\Balancer\Balancer;
use App\Balancer\Strategy\SmoothBalance;
use App\Queue\Queue;

require(__DIR__ . '/vendor/autoload.php');

$strategy = new SmoothBalance();

$strategy->add(createQueue(), 1);
$strategy->add(createQueue(), 10);
$strategy->add(createQueue(), 5);

$balancer = new Balancer($strategy, 5);

$balancer->run();


function createQueue(): Queue
{
    $queue = new Queue();

    $messagesNum = random_int(1, 100);

    for($i = 0; $i < $messagesNum; $i++) {
        $queue->enqueue("Queue id: {$queue->id}, message num: {$i}");
    }

    return $queue;
}
