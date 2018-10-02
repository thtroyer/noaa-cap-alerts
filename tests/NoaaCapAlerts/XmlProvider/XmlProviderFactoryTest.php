<?php

namespace NoaaCapAlerts\XmlProvider;

class XmlProviderFactoryTest extends \PHPUnit\Framework\TestCase
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
