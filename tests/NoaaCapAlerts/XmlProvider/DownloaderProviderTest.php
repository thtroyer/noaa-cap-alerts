<?php

namespace {
    $mockFileGetContents = false;
}

namespace NoaaCapAlerts\Tests\NoaaCapAlerts\XmlProvider {
    /*
     * Mock file_get_contents, only if global var gets set
     */

    use NoaaCapAlerts\XmlProvider\DownloaderProvider;
    use PHPUnit\Framework\TestCase;

    function file_get_contents($filename, $use_include_path = null, $context = null)
    {
        global $mockFileGetContents;
        if ($mockFileGetContents == true) {
            return \file_get_contents(__DIR__ . '/../../files/noaaExample1.xml');
        }

        return call_user_func_array('\file_get_contents', func_get_args());
    }

    class DownloaderProviderTest extends TestCase
    {
        public function testGetXml()
        {
            global $mockFileGetContents;
            $mockFileGetContents = true;

            $xmlProvider = new DownloaderProvider();

            $xml = $xmlProvider->getXml();

            $this->assertStringStartsWith("<?xml", $xml);
        }
    }

}
