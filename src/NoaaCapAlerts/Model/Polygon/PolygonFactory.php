<?php

namespace NoaaCapAlerts\Model\Polygon;


class PolygonFactory
{
    public function create(array $capPolygon): Polygon
    {
        $points = [];

        foreach ($capPolygon as $point) {
            $pointParts = explode(',', $point);
            if (sizeof($pointParts) != 2) {
                continue;
            }

            $points[] = Point::fromDecimalDegrees(
                trim($pointParts[0]),
                trim($pointParts[1])
            );
        }

        return new Polygon($points);
    }
}