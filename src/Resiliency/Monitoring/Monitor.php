<?php

namespace App\Resiliency\Monitoring;

use Resiliency\Contracts\CircuitBreaker;

final class Monitor
{
    private $servicesCalls = [];

    public function add(string $service, string $eventName, array $serviceParameters, CircuitBreaker $circuitBreaker): void
    {
        $serviceCall = new ServiceCall($service, $eventName, $serviceParameters, $circuitBreaker);

        $this->servicesCalls[] = $serviceCall;
    }

    public function getReport() : array
    {
        return (new Report($this->servicesCalls))->generate();
    }
}
