<?php

namespace App\Resiliency\System;

use Resiliency\Systems\MainSystem;
use Resiliency\Contracts\Client;

final class SystemFactory
{
    /**
     * @param array $settings
     * @return MainSystem
     */
    public function createSystem(array $settings, Client $client) : MainSystem
    {
        return MainSystem::createFromArray($settings, $client);
    }
}
