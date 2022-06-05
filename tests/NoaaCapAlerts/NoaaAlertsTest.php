<?php

namespace NoaaCapAlerts\Tests\NoaaCapAlerts;

use NoaaCapAlerts\NoaaAlerts;
use PHPUnit\Framework\TestCase;

class NoaaAlertsTest extends TestCase
{
    public function testGetAlerts()
    {
        $pathToTestFile = __DIR__ . "/../files/noaaExample1.xml";
        putenv("NoaaLocalFilePath={$pathToTestFile}");

        $noaaAlerts = new NoaaAlerts();
        $results = $noaaAlerts->getAlerts();

        $this->assertNotEmpty($results);
    }
}
