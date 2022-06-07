<?php

namespace NoaaCapAlerts\Model\Polygon;


class Point
{
    private $latitude;
    private $longitude;

    private function __construct($longitude, $latitude)
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

    public static function fromDecimalDegrees($latitude, $longitude): Point
    {
        if (self::isDecimalFormat($latitude) && self::isDecimalFormat($longitude)) {
            return new Point($longitude, $latitude);
        } elseif (self::isNsewFormat($latitude) && self::isNsewFormat($longitude)) {
            //todo
            return new Point(0, 0);
        }

        throw new \InvalidArgumentException("Unable to parse lat/long: $latitude, $longitude");
    }

    public static function fromDegreesMinutes($latitudeDegrees, $latitudeMinues, $longitudeDegrees, $longitudeMinutes): Point
    {
        //todo
        return new Point(0, 0);
    }

    public static function fromDegreesMinutesSeconds(
        $latitudeDegrees,
        $latitudeMinues,
        $latitudeSeconds,
        $longitudeDegrees,
        $longitudeMinutes,
        $longitudeSeconds): Point
    {
        //todo
        return new Point(0, 0);
    }

    private static function isDecimalFormat(string $input): bool
    {
        $output = [];
        $foundMatches = preg_match('/-?\d*\.\d+(?![NSEWnsew])/', $input, $output);

        return $foundMatches !== false;
    }

    private static function isNumericFormat(string $input): bool
    {
        $output = [];
        $foundMatches = preg_match('/-?\d*\.\d+(?![NSEWnsew])/', $input, $output);

        return $foundMatches !== false;
    }

    private static function isNsewFormat(string $input): bool
    {
        $output = [];
        $foundMatches = preg_match('/\d+\.\d+[NSEWnsew]/', $input, $output);
        $startsWithNegative = strpos($input, "-");

        return $foundMatches !== false && $startsWithNegative === false;
    }

}