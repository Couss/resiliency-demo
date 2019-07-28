<?php

namespace App\Resiliency\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

use App\Resiliency\Monitoring\Monitor;

final class ResiliencyCollector extends DataCollector
{
    private $monitor;

    public function __construct(Monitor $monitor)
    {
        $this->monitor = $monitor;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $report = $this->monitor->getReport();

        foreach($report as $uri => &$serviceCalls) {
            foreach($serviceCalls as $index => $serviceCall) {
                $serviceCalls[$index]['parameters'] = $this->cloneVar($serviceCall['parameters']);
            }
        }

        $this->data = $report;
    }

    /**
     * {@inheritdoc}
     */
    public function reset()
    {
        $this->data = [];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'resiliency.collector';
    }

    public function getReport() : array
    {
        return $this->data;
    }
}
