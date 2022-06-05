<?php

namespace NoaaCapAlerts\Tests\NoaaCapAlerts\Model;

use NoaaCapAlerts\Model\NoaaAlert;
use NoaaCapAlerts\Model\NoaaAlertFactory;
use NoaaCapAlerts\Model\Polygon\PolygonFactory;
use NoaaCapAlerts\Parser\NoaaIndexParser;
use NoaaCapAlerts\XmlProvider\XmlProvider;
use PHPUnit\Framework\TestCase;

class NoaaAlertManagerTest extends TestCase
{

    public function testGetAlerts()
    {
        $mockXmlProvider = $this->createMock(XmlProvider::class);

        $mockXmlProvider->expects($this->once())
                        ->method('getXml')
                        ->willReturn('some xml');

        $mockIndexParser = $this->createMock(NoaaIndexParser::class);

        $mockIndexParser->expects($this->once())
                        ->method('parse')
                        ->with($this->stringContains('some xml'))
                        ->willReturn($this->getParsedData());

        $mockPolygonFactory = $this->createMock(PolygonFactory::class);

        $noaaAlertManager = new NoaaAlertFactory($mockXmlProvider, $mockIndexParser, $mockPolygonFactory);
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
