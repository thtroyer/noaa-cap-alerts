<?php

namespace NoaaCapAlerts\Tests\NoaaCapAlerts\XmlProvider;


use NoaaCapAlerts\XmlProvider\FileProvider;
use PHPUnit\Framework\TestCase;

class FileProviderTest extends TestCase
{

    public function testGetXml()
    {
        $localFilePath = __DIR__ . "/../../files/noaaExample1.xml";
        $xmlProvider = new FileProvider($localFilePath);

        $xml = $xmlProvider->getXml();

        $this->assertStringStartsWith("<?xml", $xml);
    }
}
