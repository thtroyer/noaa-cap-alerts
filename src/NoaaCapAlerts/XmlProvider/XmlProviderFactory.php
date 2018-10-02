<?php

namespace NoaaCapAlerts\XmlProvider;

class XmlProviderFactory
{
    protected $localFilePath;

    function __construct(string $localFilePath = null)
    {
        $this->localFilePath = $localFilePath;
    }

    public function getXmlProvider() : XmlProvider
    {
        if (!empty($this->localFilePath)) {
            return new FileProvider($this->localFilePath);
        }

        return new DownloaderProvider();
    }
}