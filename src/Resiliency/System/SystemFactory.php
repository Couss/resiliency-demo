<?php

namespace App\Resiliency\System;

use Resiliency\Systems\MainSystem;

final class SystemFactory
{
    /**
     * @param array $settings
     * @return MainSystem
     */
    public function createSystem(array $settings) : MainSystem
    {
        return MainSystem::createFromArray($settings);
    }
}
