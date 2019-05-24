<?php

namespace App\EventSubscriber;

use App\Resiliency\Monitoring\Monitor;
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
            'resiliency.'.strtolower(Transitions::INITIATING_TRANSITION) => 'monitorEvent',
            'resiliency.'.strtolower(Transitions::OPENING_TRANSITION) => 'monitorEvent',
            'resiliency.'.strtolower(Transitions::CHECKING_AVAILABILITY_TRANSITION) => 'monitorEvent',
            'resiliency.'.strtolower(Transitions::REOPENING_TRANSITION) => 'monitorEvent',
            'resiliency.'.strtolower(Transitions::CLOSING_TRANSITION) => 'monitorEvent',
            'resiliency.'.strtolower(Transitions::TRIAL_TRANSITION) => 'monitorEvent',
        ];
    }

    public function monitorEvent(TransitionEvent $event)
    {
        $this->monitor->add(
            $event->getService(),
            $event->getEvent(),
            $event->getParameters(),
            $event->getCircuitBreaker()
        );
    }
}
