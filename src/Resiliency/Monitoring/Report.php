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
            $report[$serviceCall->getUri()][] = [
                'transition' => $serviceCall->getTransition(),
                'parameters' => $serviceCall->getParameters(),
                'state' => $serviceCall->getState(),
                'datetime' => $serviceCall->getDatetime(),
            ];
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
