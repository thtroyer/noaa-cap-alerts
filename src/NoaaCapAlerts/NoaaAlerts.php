<?php

namespace NoaaCapAlerts;

class NoaaAlerts
{
    private $dependencyContainer;

    public function __construct()
    {
        $this->dependencyContainer = new Dependencies();
    }

    public function getAlerts(): array
    {
        $noaaAlertManager = $this->dependencyContainer['NoaaAlertManager'];

        return $noaaAlertManager->getAlerts();
    }
}