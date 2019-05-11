<?php

namespace App\Resiliency\Monitoring;

use DateTime;

final class ServiceCall
{
    private $datetime;
    private $uri;
    private $state;
    private $parameters;

    public function __construct(string $uri, string $state, array $parameters)
    {
        $this->uri = $uri;
        $this->state = $state;
        $this->parameters = $parameters;
        $this->datetime = new DateTime();
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getDatetime() : DateTime
    {
        return $this->datetime;
    }
}
