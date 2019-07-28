<?php

namespace App\Resiliency\Monitoring;

use Resiliency\Contracts\CircuitBreaker;
use Resiliency\Contracts\Service;

final class Monitor
{
    private $servicesCalls = [];

    public function add(Service $service, CircuitBreaker $circuitBreaker, string $transition): void
    {
        $serviceCall = new ServiceCall($service, $circuitBreaker, $transition);

        $this->servicesCalls[] = $serviceCall;
    }

    public function getReport() : array
    {
        return (new Report($this->servicesCalls))->generate();
    }
}
