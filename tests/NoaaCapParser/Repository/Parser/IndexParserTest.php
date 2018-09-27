<?php
namespace NoaaCapParser\Tests;

use NoaaCapParser\Exceptions\XmlParseException;
use NoaaCapParser\Repository\Parser\IndexParser;

class XmlParserTest extends \PHPUnit\Framework\TestCase
{

    public function testEmptyRequest()
    {
        $this->expectException(XmlParseException::class);

        $xml = '';
        $parser = new IndexParser();

        $parser->parse($xml);
    }

    public function testSimpleRequest()
    {
        $xml = file_get_contents(__DIR__ . '/../../../files/noaaExampleSmall.xml');
        $parser = new IndexParser();
        $result = $parser->parse($xml);

        $expectedResult = array(
            array(
                'idString' => 'https://alerts.weather.gov/cap/wwacapget.php?x=AK125867734B60.SpecialWeatherStatement.12586773BBE0AK.AFGSPSAFG.88fff69aab9bb2a74b526abf4c216ea1',
                'idKey' => 'AK125867734B60.88fff69aab9bb2a74b526abf4c216ea1',
                'updatedTime' => '2017-09-01 19:12:00',
                'publishedTime' => '2017-09-01 19:12:00',
                'authorName' => 'w-nws.webmaster@noaa.gov',
                'title' => 'Special Weather Statement issued September 01 at 7:12PM AKDT by NWS',
                'link' => 'https://alerts.weather.gov/cap/wwacapget.php?x=AK125867734B60.SpecialWeatherStatement.12586773BBE0AK.AFGSPSAFG.88fff69aab9bb2a74b526abf4c216ea1',
                'summary' => '...Thunderstorms over the Tanana Valley... A line of thunderstorms developed along the length of the Tanana River from Northway to Tanana late this afternoon. This line of thunderstorms moved north over Fairbanks and North Pole between 6 and 7 pm with winds gusting to 30 mph along with brief heavy rain and lightning. Up to one tenth of an inch of rain can be expected.',
                'capEvent' => 'Special Weather Statement',
                'capEffectiveTime' => '2017-09-01 19:12:00',
                'capExpiresTime' => '2017-09-01 22:00:00',
                'capStatus' => 'Actual',
                'capMsgType' => 'Alert',
                'capCategory' => 'Met',
                'capUrgencyExpected' => 'Expected',
                'capSeverity' => 'Minor',
                'capCertainty' => 'Observed',
                'capAreaDesc' => 'Central Interior; Deltana and Tanana Flats; Middle Tanana Valley; Upper Tanana Valley and the Fortymile Country',
                'capPolygon' => array(
                    '0' => '',
                ),
                'capGeo' => array(
                    'FIPS6' => array(
                        '0' => '002090',
                        '1' => '002240',
                        '2' => '002290',
                    ),
                    'UGC' => array(
                        '0' => 'AKZ221',
                        '1' => 'AKZ222',
                        '2' => 'AKZ223',
                        '3' => 'AKZ224',
                    ),
                ),
                'capGeoString' => 'FIPS6, 002090 002240 002290, UGC, AKZ221 AKZ222 AKZ223 AKZ224',
                'capParameters' => '',
                'updatedDateTime' => new \DateTime('2017-09-01T19:12:00-08:00'),
                'publishedDateTime' => new \DateTime('2017-09-01T19:12:00-08:00'),
                'capEffectiveDateTime' => new \DateTime('2017-09-01T19:12:00-08:00'),
                'capExpiresDateTime' => new \DateTime('2017-09-01T22:00:00-08:00'),


            ),
        );

        $this->assertEquals($expectedResult, $result);
    }
}
