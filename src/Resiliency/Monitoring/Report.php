<?php

namespace App\Resiliency\Monitoring;

use DateTime;

final class Report
{
    private $serviceCalls;

    public function __construct($serviceCalls)
    {
        $this->serviceCalls = $serviceCalls;
    }

    public function generate() : array
    {
        $report = $this->populateServicesList();

        /** @var ServiceCall $serviceCall */
        foreach ($this->serviceCalls as $serviceCall) {
            $report[$serviceCall->getUri()][] = $serviceCall->toArray();
        }

        return $report;
    }

    private function populateServicesList() : array
    {
        $report = [];

        /** @var ServiceCall $serviceCall */
        foreach ($this->serviceCalls as $serviceCall) {
            $report[$serviceCall->getUri()] = [];
        }

        return $report;
    }
}
