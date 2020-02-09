<?php

namespace NoaaCapAlerts\Model;


use NoaaCapAlerts\Model\Polygon\PolygonFactory;
use NoaaCapAlerts\Parser\NoaaIndexParser;
use NoaaCapAlerts\XmlProvider\XmlProvider;

class NoaaAlertFactory
{
    private $xmlProvider;
    private $indexParser;
    private $polygonFactory;

    public function __construct(XmlProvider $xmlProvider, NoaaIndexParser $indexParser, PolygonFactory $polygonFactory)
    {
        $this->xmlProvider = $xmlProvider;
        $this->indexParser = $indexParser;
        $this->polygonFactory = $polygonFactory;
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
                $data['vtec'],
                $this->polygonFactory->create($data['capPolygon'])
            );

            $alerts[] = $alert;
        }

        return $alerts;
    }
}