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

    public function isPointInPolygon(Point $targetPoint): bool
    {
        $targetLatitude = $targetPoint->getLatitude();
        $longitudeHits = [];
        $lastPoint = $this->points[array_key_last($this->points)];
        foreach ($this->points as $point) {
            if ($this->doLinesCrossLatitude($lastPoint, $point, $targetLatitude)) {
                $longitudeHits[] = $this->findInterceptLongitude($lastPoint, $point, $targetLatitude);
            }
            $lastPoint = $point;
        }

        $longitudeHits = array_unique($longitudeHits);
        sort($longitudeHits);

        $hitsBefore = 0;
        $hitsAfter = 0;

        foreach ($longitudeHits as $hit) {
            if ($hit <= $targetPoint->getLongitude()) {
                $hitsBefore++;
            } elseif ($hit >= $targetPoint->getLongitude()) {
                $hitsAfter++;
            }
        }

        if (($hitsBefore % 2 == 1) && ($hitsAfter % 2 == 1)) {
            return true;
        } elseif (($hitsBefore % 2 == 0) && ($hitsAfter % 2 == 0)) {
            return false;
        }

        throw new \Exception("Something weird happened.  Fixme");
    }

    private function doLinesCrossLatitude(Point $point1, Point $point2, float $latitude): bool
    {
        if ($point1->getLatitude() >= $latitude && $point2->getLatitude() <= $latitude) {
            return true;
        } elseif ($point2->getLatitude() >= $latitude && $point1->getLatitude() <= $latitude) {
            return true;
        } else {
            return false;
        }
    }

    private function findInterceptLongitude(Point $point1, Point $point2, float $latitude): float
    {
        if ($point2->getLongitude() - $point1->getLongitude() == 0) {
            return $point2->getLongitude();
        }

        $slope = ($point2->getLatitude() - $point1->getLatitude()) / ($point2->getLongitude() - $point1->getLongitude());
        $b = $point1->getLatitude() - ($slope * $point1->getLongitude());

        return ($latitude + $b) / $slope;
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