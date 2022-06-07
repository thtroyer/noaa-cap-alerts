<?php

namespace NoaaCapAlerts\Tests\NoaaCapAlerts\Model\Polygon;

use NoaaCapAlerts\Model\Polygon\Point;
use NoaaCapAlerts\Model\Polygon\Polygon;
use PHPUnit\Framework\TestCase;

class PolygonTest extends TestCase
{

    public function testPointInSimplePolygon()
    {
        $point = Point::fromDecimalDegrees(2.5, 2.5);

        $polygon = new Polygon(
            array(
                Point::fromDecimalDegrees(0, 0),
                Point::fromDecimalDegrees(5, 0),
                Point::fromDecimalDegrees(5, 5),
                Point::fromDecimalDegrees(0, 5),
            )
        );

        $this->assertTrue($polygon->isPointInPolygon($point));
    }

    public function testPointNotInSimplePolygon()
    {
        $point = Point::fromDecimalDegrees(6, 2.5);

        $polygon = new Polygon(
            array(
                Point::fromDecimalDegrees(0, 0),
                Point::fromDecimalDegrees(5, 0),
                Point::fromDecimalDegrees(5, 5),
                Point::fromDecimalDegrees(0, 5),
                Point::fromDecimalDegrees(0, 0),
            )
        );

        $this->assertFalse($polygon->isPointInPolygon($point));
    }
}
