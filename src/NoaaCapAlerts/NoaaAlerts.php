<?php

namespace NoaaCapAlerts;

class NoaaAlerts
{
    private $dependencyContainer;

    function __construct($url = '', $xml = '')
    {
        $this->dependencyContainer = new Dependencies();
    }

    function getAlerts(): array
    {
        $noaaAlertManager = $this->dependencyContainer['NoaaAlertManager'];

        return $noaaAlertManager->getAlerts();
    }
}