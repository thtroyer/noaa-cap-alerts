<?php

namespace NoaaCapParser\Repository;

use NoaaCapParser\Repository\Parser\DetailParser;
use NoaaCapParser\Repository\Parser\IndexParser;
use NoaaCapParser\Repository\XmlProvider\XmlProviderInterface;

class DownloaderProvider implements XmlProviderInterface
{
    protected $detailParser;
    protected $indexParser;
    protected $indexUrl;

    function __construct(DetailParser $detailParser, IndexParser $indexParser, string $indexUrl = 'http://alerts.weather.gov/cap/us.php?x=0')
    {
        $this->indexUrl = $indexUrl;
        $this->detailParser = $detailParser;
        $this->indexParser = $indexParser;
    }

    public function downloadParsedIndex() : array
    {
        $alertArray = $this->indexParser->parse($this->indexUrl);

        return $alertArray;
    }

    public function downloadParsedDetails() : array
    {
        $alerts = $this->downloadParsedIndex();

        $detailedAlerts = array();
        foreach ($alerts as $alert) {
            $url = $alert['id'];

            $xml = $this->downloadXml($url);
            $detailedAlerts[] = $this->detailParser->parse($xml);
        }

        return $detailedAlerts;
    }

    protected function downloadXml($url)
    {
        $options = array(
            'http' => array(
                'header' => "User-agent: noaa-cap-parser',"
            ),
        );

        $context = stream_context_create($options);
        $xml = file_get_contents( $url,false, $context);

        return $xml;
    }
}

