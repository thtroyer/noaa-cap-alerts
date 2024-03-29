<?php

namespace NoaaCapAlerts;

class NoaaAlerts
{
    private Dependencies $dependencyContainer;

    public function __construct()
    {
        $this->dependencyContainer = new Dependencies();
    }

    public function getAlerts(): array
    {
        $noaaAlertManager = $this->dependencyContainer['NoaaAlertManager'];

        return $noaaAlertManager->getAlerts();
    }

    public static function fetchAlerts(): array
    {
        $noaaAlerts = new NoaaAlerts();

        return $noaaAlerts->getAlerts();
    }
}