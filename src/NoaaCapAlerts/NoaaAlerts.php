<?php

namespace NoaaCapAlerts;

class NoaaAlerts
{
    private $dependencyContainer;

    function __construct()
    {
        $this->dependencyContainer = new Dependencies();
    }

    function getAlerts(): array
    {
        $noaaAlertManager = $this->dependencyContainer['NoaaAlertManager'];

        return $noaaAlertManager->getAlerts();
    }
}