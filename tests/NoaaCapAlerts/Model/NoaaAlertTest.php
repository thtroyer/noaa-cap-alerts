<?php

namespace NoaaCapAlerts\Tests\Model;

use NoaaCapAlerts\Model\NoaaAlert;

class NoaaAlertTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider alertDataProvider
     */
    public function testGetters(array $data)
    {
        $noaaAlert = $this->generateNoaaAlertFromArray($data);

        $this->assertEquals($data['idString'], $noaaAlert->getIdString());
        $this->assertEquals($data['idKey'], $noaaAlert->getIdKey());
        $this->assertEquals($data['updatedTime'], $noaaAlert->getUpdatedTime());
        $this->assertEquals($data['publishedTime'], $noaaAlert->getPublishedTime());
        $this->assertEquals($data['authorName'], $noaaAlert->getAuthorName());
        $this->assertEquals($data['title'], $noaaAlert->getTitle());
        $this->assertEquals($data['link'], $noaaAlert->getLink());
        $this->assertEquals($data['summary'], $noaaAlert->getSummary());
        $this->assertEquals($data['capEvent'], $noaaAlert->getCapEvent());
        $this->assertEquals($data['capEffectiveTime'], $noaaAlert->getCapEffectiveTime());
        $this->assertEquals($data['capExpiresTime'], $noaaAlert->getCapExpiresTime());
        $this->assertEquals($data['capStatus'], $noaaAlert->getCapStatus());
        $this->assertEquals($data['capMsgType'], $noaaAlert->getCapMsgType());
        $this->assertEquals($data['capCategory'], $noaaAlert->getCapCategory());
        $this->assertEquals($data['capUrgencyExpected'], $noaaAlert->getCapUrgencyExpected());
        $this->assertEquals($data['capSeverity'], $noaaAlert->getCapSeverity());
        $this->assertEquals($data['capCertainty'], $noaaAlert->getCapCertainty());
        $this->assertEquals($data['capAreaDesc'], $noaaAlert->getCapAreaDesc());
        $this->assertEquals($data['capPolygon'], $noaaAlert->getCapPolygon());
        $this->assertEquals($data['capGeo'], $noaaAlert->getCapGeo());
        $this->assertEquals($data['capGeoString'], $noaaAlert->getCapGeoString());
        $this->assertEquals($data['vtec'], $noaaAlert->getVtec());
    }

    /**
     * @dataProvider alertDataProvider
     */
    public function testToArray($data)
    {
        $noaaAlert = $this->generateNoaaAlertFromArray($data);

        $this->assertEquals($data, $noaaAlert->toArray());
    }

    protected function generateNoaaAlertFromArray(array $data): NoaaAlert
    {
        return new NoaaAlert(
            $data['idString'],
            $data['idKey'],
            $data['updatedTime'],
            $data['publishedTime'],
            $data['authorName'],
            $data['title'],
            $data['link'],
            $data['summary'],
            $data['capEvent'],
            $data['capEffectiveTime'],
            $data['capExpiresTime'],
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
    }

    public function alertDataProvider()
    {
        return array(
            array(
                array(
                    'idString' => 'idString',
                    'idKey' => 'idKey',
                    'updatedTime' => new \DateTime('2018-01-01 12:01:01'),
                    'publishedTime' => new \DateTime('2018-01-01 12:02:02'),
                    'authorName' => 'authorName',
                    'title' => 'title',
                    'link' => 'link',
                    'summary' => 'summary',
                    'capEvent' => 'capEvent',
                    'capEffectiveTime' => new \DateTime('2018-01-01 12:02:02'),
                    'capExpiresTime' => new \DateTime('2018-01-01 12:02:02'),
                    'capStatus' => 'capStatus',
                    'capMsgType' => 'capMsgType',
                    'capCategory' => 'capCategory',
                    'capUrgencyExpected' => 'capUrgencyExpected',
                    'capSeverity' => 'capSeverity',
                    'capCertainty' => 'capCertainty',
                    'capAreaDesc' => 'capAreaDesc',
                    'capPolygon' => array('1'),
                    'capGeo' => array('2'),
                    'capGeoString' => 'capGeoString',
                    'vtec' => 'vtec',
                ),
            ),
        );
    }

}
