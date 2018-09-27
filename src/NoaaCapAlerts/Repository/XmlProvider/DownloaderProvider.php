<?php

namespace NoaaCapAlerts\Repository\XmlProvider;

class DownloaderProvider implements XmlProvider
{
    protected $detailParser;
    protected $indexParser;
    protected $indexUrl;

    function __construct(string $indexUrl = 'http://alerts.weather.gov/cap/us.php?x=0')
    {
        $this->indexUrl = $indexUrl;
    }

    public function getXml() : string
    {
        $options = array(
            'http' => array(
                'header' => "User-agent: noaa-cap-parser',"
            ),
        );

        $context = stream_context_create($options);
        $xml = file_get_contents($this->indexUrl,false, $context);

        return $xml;
    }
}

