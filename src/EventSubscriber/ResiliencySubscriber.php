<?php

namespace App\EventSubscriber;

use App\Resiliency\Monitoring\Monitor;
use Resiliency\Events\AvailabilityChecked;
use Resiliency\Events\Initiated;
use Resiliency\Events\Closed;
use Resiliency\Events\Opened;
use Resiliency\Events\ReOpened;
use Resiliency\Events\Tried;
use Resiliency\Transitions;
use Resiliency\Events\TransitionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ResiliencySubscriber implements EventSubscriberInterface
{
    private $monitor;

    public function __construct(Monitor $monitor)
    {
        $this->monitor = $monitor;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            Initiated::class => 'monitorEvent',
            Opened::class => 'monitorEvent',
            AvailabilityChecked::class => 'monitorEvent',
            ReOpened::class => 'monitorEvent',
            Closed::class => 'monitorEvent',
            Tried::class => 'monitorEvent',
        ];
    }

    public function monitorEvent(TransitionEvent $event)
    {
        $this->monitor->add(
            $event->getService(),
            $event->getCircuitBreaker(),
            get_class($event)
        );
    }
}
