<?php

namespace NoaaCapAlerts\XmlProvider;

class DownloaderProvider implements XmlProvider
{
    protected string $indexUrl;

    public function __construct(string $indexUrl = 'http://alerts.weather.gov/cap/us.php?x=0')
    {
        $this->indexUrl = $indexUrl;
    }

    public function getXml(): string
    {
        $options = array(
            'http' => array(
                'header' => "User-agent: thtroyer/noaa-cap-alerts',"
            ),
        );

        $context = stream_context_create($options);

        return file_get_contents($this->indexUrl, false, $context);
    }
}

