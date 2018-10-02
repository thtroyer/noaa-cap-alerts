<?php

namespace NoaaCapAlerts\XmlProvider;


class FileProviderTest extends \PHPUnit\Framework\TestCase
{

    public function testGetXml()
    {
        $localFilePath = __DIR__ . "/../../files/noaaExample1.xml";
        $xmlProvider = new FileProvider($localFilePath);

        $xml = $xmlProvider->getXml();

        $this->assertStringStartsWith("<?xml", $xml);
    }
}
