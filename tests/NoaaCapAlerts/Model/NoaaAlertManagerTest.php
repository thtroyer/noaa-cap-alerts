<?php

namespace NoaaCapAlerts\Model;

use NoaaCapAlerts\Parser\IndexParser;
use NoaaCapAlerts\XmlProvider\XmlProvider;

class NoaaAlertManagerTest extends \PHPUnit\Framework\TestCase
{

    public function testGetAlerts()
    {
        $mockXmlProvider = $this->createMock(XmlProvider::class);

        $mockXmlProvider->expects($this->once())
                        ->method('getXml')
                        ->willReturn('some xml');

        $mockIndexParser = $this->createMock(IndexParser::class);

        $mockIndexParser->expects($this->once())
                        ->method('parse')
                        ->with($this->stringContains('some xml'))
                        ->willReturn($this->getParsedData());

        $noaaAlertManager = new NoaaAlertManager($mockXmlProvider, $mockIndexParser);
        $alerts = $noaaAlertManager->getAlerts();

        $this->assertCount(1, $alerts);
        $this->assertInstanceOf(NoaaAlert::class, $alerts[0]);
    }

    private function getParsedData()
    {
        return array(
            array(
                'idString' => 'idString',
                'idKey' => 'idKey',
                'updatedDateTime' => new \DateTime(),
                'publishedDateTime' => new \DateTime(),
                'authorName' => 'authorName',
                'title' => 'title',
                'link' => 'link',
                'summary' => 'summary',
                'capEvent' => 'capEvent',
                'capEffectiveDateTime' => new \DateTime(),
                'capExpiresDateTime' => new \DateTime(),
                'capStatus' => 'capStatus',
                'capMsgType' => 'capMsgType',
                'capCategory' => 'capCategory',
                'capUrgencyExpected' => 'capUrgencyExpected',
                'capSeverity' => 'capSeverity',
                'capCertainty' => 'capCertainty',
                'capAreaDesc' => 'capAreaDesc',
                'capPolygon' => array(),
                'capGeo' => array(),
                'capGeoString' => 'capGeoString',
                'vtec' => 'vtec',
            ),
        );
    }
}
