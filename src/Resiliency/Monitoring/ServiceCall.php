<?php

namespace App\Resiliency\Monitoring;

use Resiliency\Contracts\CircuitBreaker;
use DateTime;

final class ServiceCall
{
    private $datetime;
    private $uri;
    private $transition;
    private $parameters;
    private $circuitBreaker;

    public function __construct(
        string $uri,
        string $transition,
        array $parameters,
        CircuitBreaker $circuitBreaker
    ) {
        $this->uri = $uri;
        $this->transition = $transition;
        $this->parameters = $parameters;
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
        return $this->circuitBreaker->getState();
    }

    public function getDatetime() : DateTime
    {
        return $this->datetime;
    }
}
