<?php

namespace NoaaCapAlerts\Tests\NoaaCapAlerts\Model\Polygon;

use NoaaCapAlerts\Model\Polygon\Point;
use NoaaCapAlerts\Model\Polygon\Polygon;
use PHPUnit\Framework\TestCase;

class PolygonTest extends TestCase
{

    public function testPointInSimplePolygon()
    {
        $point = new Point(2.5, 2.5);

        $polygon = new Polygon(
            array(
                new Point(0, 0),
                new Point(5, 0),
                new Point(5, 5),
                new Point(0, 5),
            )
        );

        $this->assertTrue($polygon->isPointInPolygon($point));
    }

    public function testPointNotInSimplePolygon()
    {
        $point = new Point(6, 2.5);

        $polygon = new Polygon(
            array(
                new Point(0, 0),
                new Point(5, 0),
                new Point(5, 5),
                new Point(0, 5),
                new Point(0, 0),
            )
        );

        $this->assertFalse($polygon->isPointInPolygon($point));
    }
}
