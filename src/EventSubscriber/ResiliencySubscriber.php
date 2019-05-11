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
            'resiliency.'.strtolower(Transitions::INITIATING_TRANSITION) => 'handleInitiation',
            'resiliency.'.strtolower(Transitions::OPENING_TRANSITION) => 'handleOpening',
            'resiliency.'.strtolower(Transitions::CHECKING_AVAILABILITY_TRANSITION) => 'handleAvailabilityChecking',
            'resiliency.'.strtolower(Transitions::REOPENING_TRANSITION) => 'handleReopening',
            'resiliency.'.strtolower(Transitions::CLOSING_TRANSITION) => 'handleClosing',
            'resiliency.'.strtolower(Transitions::TRIAL_TRANSITION) => 'handleTrialing',
        ];
    }

    public function handleInitiation(TransitionEvent $event)
    {
        $this->monitor->add($event->getService(), $event->getEvent(), $event->getParameters());
    }

    public function handleOpening(TransitionEvent $event)
    {
        $this->monitor->add($event->getService(), $event->getEvent(), $event->getParameters());
    }

    public function handleAvailabilityChecking(TransitionEvent $event)
    {
        $this->monitor->add($event->getService(), $event->getEvent(), $event->getParameters());
    }

    public function handleReopening(TransitionEvent $event)
    {
        $this->monitor->add($event->getService(), $event->getEvent(), $event->getParameters());
    }

    public function handleClosing(TransitionEvent $event)
    {
        $this->monitor->add($event->getService(), $event->getEvent(), $event->getParameters());
    }

    public function handleTrialing(TransitionEvent $event)
    {
        $this->monitor->add($event->getService(), $event->getEvent(), $event->getParameters());
    }
}
