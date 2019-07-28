<?php

namespace App\Resiliency\Monitoring;

use Resiliency\Contracts\CircuitBreaker;
use Resiliency\Contracts\Service;
use DateTime;

final class ServiceCall
{
    private $datetime;
    private $uri;
    private $transition;
    private $parameters;
    private $circuitBreaker;

    public function __construct(
        Service $service,
        CircuitBreaker $circuitBreaker,
        string $transition
    ) {
        $this->uri = $service->getURI();
        $this->transition = $transition;
        $this->parameters = $service->getParameters();
        $this->circuitBreaker = $circuitBreaker;
        $this->datetime = new DateTime();
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getTransition(): string
    {
        return $this->transition;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getState(): string
    {
        return $this->circuitBreaker->getState()->getState();
    }

    public function getDatetime() : DateTime
    {
        return $this->datetime;
    }

    public function toArray() : array
    {
        return [
            'uri' => $this->getUri(),
            'transition' => $this->getTransition(),
            'parameters' => $this->getParameters(),
            'state' => $this->getState(),
            'datetime' => $this->getDatetime(),
        ];
    }
}
