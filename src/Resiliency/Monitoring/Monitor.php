<?php

namespace App\Resiliency\Monitoring;

final class Monitor
{
    private $servicesCalls = [];

    public function add(string $service, string $eventName, array $serviceParameters): void
    {
        $serviceCall = new ServiceCall($service, $eventName, $serviceParameters);

        $this->servicesCalls[] = $serviceCall;
    }

    public function getReport() : array
    {
        return (new Report($this->servicesCalls))->generate();
    }
}
