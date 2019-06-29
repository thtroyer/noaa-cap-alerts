<?php

namespace NoaaCapAlerts\Model\Polygon;

class Polygon
{
    private $points;

    /**
     * Polygon constructor.
     * @param array $points
     */
    function __construct(array $points = null)
    {
        if ($points === null) {
            $points = [];
        }

        $this->points = $points;
    }

    function isPointInPolygon(Point $point) {
        //@todo
        throw new \Exception("Method not implemented.");
    }

    function __toString()
    {
        $pointStrings = [];
        foreach ($this->points as $point) {
            $pointStrings[] = '[' . $point->getX() . ', ' . $point->getY() . ']';
        }

        return "Points: " . implode(', ', $pointStrings);
    }
}