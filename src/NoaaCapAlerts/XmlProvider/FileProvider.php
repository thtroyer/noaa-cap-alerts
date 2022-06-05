<?php

namespace NoaaCapAlerts\XmlProvider;

class FileProvider implements XmlProvider
{
    protected string $filePath;

    public function __construct(string $filePath = '')
    {
        $this->filePath = $filePath;
    }

    public function getXml(): string
    {
        $xml = file_get_contents($this->filePath);

        return $xml;
    }
}
