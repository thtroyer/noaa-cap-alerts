<?php

namespace NoaaCapAlerts\Model;


use NoaaCapAlerts\Parser\IndexParser;
use NoaaCapAlerts\XmlProvider\XmlProvider;

class NoaaAlertManager
{
    private $xmlProvider;
    private $indexParser;

    public function __construct(XmlProvider $xmlProvider, IndexParser $indexParser)
    {
        $this->xmlProvider = $xmlProvider;
        $this->indexParser = $indexParser;
    }

    public function getAlerts(): array
    {
        $alerts = array();
        $alertData = $this->indexParser->parse($this->xmlProvider->getXml());

        foreach ($alertData as $data) {
            $alert = new NoaaAlert(
                $data['idString'],
                $data['idKey'],
                $data['updatedDateTime'],
                $data['publishedDateTime'],
                $data['authorName'],
                $data['title'],
                $data['link'],
                $data['summary'],
                $data['capEvent'],
                $data['capEffectiveDateTime'],
                $data['capExpiresDateTime'],
                $data['capStatus'],
                $data['capMsgType'],
                $data['capCategory'],
                $data['capUrgencyExpected'],
                $data['capSeverity'],
                $data['capCertainty'],
                $data['capAreaDesc'],
                $data['capPolygon'],
                $data['capGeo'],
                $data['capGeoString'],
                $data['vtec']
            );

            $alerts[] = $alert;
        }

        return $alerts;
    }
}