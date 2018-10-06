<?php

namespace NoaaCapAlerts;

class NoaaAlertsTest extends \PHPUnit\Framework\TestCase
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
