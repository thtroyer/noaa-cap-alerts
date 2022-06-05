<?php

namespace NoaaCapAlerts\Tests\NoaaCapAlerts\XmlProvider;

use NoaaCapAlerts\XmlProvider\DownloaderProvider;
use NoaaCapAlerts\XmlProvider\FileProvider;
use NoaaCapAlerts\XmlProvider\XmlProviderFactory;
use PHPUnit\Framework\TestCase;

class XmlProviderFactoryTest extends TestCase
{
    public function testGetDownloadProvider()
    {
        $localFilePath = null;
        $xmlProviderFactory = new XmlProviderFactory($localFilePath);
        $xmlProvider = $xmlProviderFactory->getXmlProvider();

        $this->assertInstanceOf(DownloaderProvider::class, $xmlProvider);
    }

    public function testGetFileProvider()
    {
        $localFilePath = __DIR__ . "../../files/noaaExample1.xml";
        $xmlProviderFactory = new XmlProviderFactory($localFilePath);
        $xmlProvider = $xmlProviderFactory->getXmlProvider();

        $this->assertInstanceOf(FileProvider::class, $xmlProvider);
    }
}
