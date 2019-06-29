<?php

namespace NoaaCapAlerts\Model\Polygon;


class Point
{
    private $latitude;
    private $longitude;

    public function __construct($longitude, $latitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }
}