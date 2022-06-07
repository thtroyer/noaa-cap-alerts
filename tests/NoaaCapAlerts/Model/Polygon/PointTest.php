<?php

namespace NoaaCapAlerts\Tests\NoaaCapAlerts\Model\Polygon;

use NoaaCapAlerts\Model\Polygon\Point;
use PHPUnit\Framework\TestCase;

class PointTest extends TestCase
{

    public function testConstructorAndGetters()
    {
        $longitude = 34.2;
        $latitude = 11;

        $point = Point::fromDecimalDegrees($latitude, $longitude);

        $this->assertEquals($longitude, $point->getLongitude());
        $this->assertEquals($latitude, $point->getLatitude());
    }
}
