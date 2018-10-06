<?php

namespace NoaaCapAlerts\Parser;

class IndexParser
{
    protected $xmlParser;

    function __construct(XmlParser $xmlParser = null)
    {
        if ($xmlParser === null) {
            $this->xmlParser = new XmlParser();
        } else {
            $this->xmlParser = $xmlParser;
        }
    }

    public function parse(string $xml): array
    {
        // parse XML into an array of alerts
        $rawDataArray = $this->xmlParser->getArrayFromXml($xml);
        $alertDataArray = $rawDataArray[0]['children'];

        // Process each alert ("ENTRY")
        $resultArray = array();

        foreach ($alertDataArray as $alert) {
            if (!$this->isAlert($alert)) {
                continue;
            }

            $parsedAlert = $this->parseAlert($alert);

            $resultArray[] = $parsedAlert;
        }

        return $resultArray;
    }

    protected function isAlert(array $alert): bool
    {
        return isset($alert['name']) && $alert['name'] == 'ENTRY';
    }

    protected function parseAlert(array $alert): array
    {
        $parsedAlert = array(
            'idString' => '',
            'idKey' => '',
            'updatedDateTime' => null,
            'publishedDateTime' => null,
            'updatedTime' => '',
            'publishedTime' => '',
            'authorName' => '',
            'title' => '',
            'link' => '',
            'summary' => '',
            'capEvent' => '',
            'capEffectiveTime' => '',
            'capExpiresTime' => '',
            'capEffectiveDateTime' => null,
            'capExpiresDateTime' => null,
            'capStatus' => '',
            'capMsgType' => '',
            'capCategory' => '',
            'capUrgencyExpected' => '',
            'capSeverity' => '',
            'capCertainty' => '',
            'capAreaDesc' => '',
            'capPolygon' => '',
            'capGeo' => array(),
            'capGeoString' => '',
            'vtec' => '',
        );

        // Loop through attributes and set values
        foreach ($alert['children'] as $element) {
            $elementName = $element['name'];
            $elementAttrs = $element['attrs'];
            if (isset($element['tagData'])) {
                $elementData = $element['tagData'];
            } else {
                $elementData = '';
            }

            switch ($elementName) {
                case 'ID':
                    $parsedAlert['idString'] = $elementData;
                    break;
                case 'UPDATED':
                    $parsedAlert['updatedDateTime'] = new \DateTime($elementData);
                    $parsedAlert['updatedTime'] = $parsedAlert['updatedDateTime']->format('Y-m-d H:i:s');
                    break;
                case 'PUBLISHED':
                    $parsedAlert['publishedDateTime'] = new \DateTime($elementData);
                    $parsedAlert['publishedTime'] = $parsedAlert['publishedDateTime']->format('Y-m-d H:i:s');
                    break;
                case 'AUTHOR':
                    $parsedAlert['authorName'] = $element['children'][0]['tagData'];
                    break;
                case 'TITLE':
                    $parsedAlert['title'] = $elementData;
                    break;
                case 'LINK':
                    $parsedAlert['link'] = $elementAttrs['HREF'];
                    break;
                case 'SUMMARY':
                    $parsedAlert['summary'] = $elementData;
                    break;
                case 'CAP:EVENT':
                    $parsedAlert['capEvent'] = $elementData;
                    break;
                case 'CAP:EFFECTIVE':
                    $effectiveDateTime = new \DateTime($elementData);
                    $parsedAlert['capEffectiveTime'] = $effectiveDateTime->format('Y-m-d H:i:s');
                    $parsedAlert['capEffectiveDateTime'] = $effectiveDateTime;
                    break;
                case 'CAP:EXPIRES':
                    $expiresDateTime = new \DateTime($elementData);
                    $parsedAlert['capExpiresTime'] = $expiresDateTime->format('Y-m-d H:i:s');
                    $parsedAlert['capExpiresDateTime'] = $expiresDateTime;
                    break;
                case 'CAP:STATUS':
                    $parsedAlert['capStatus'] = $elementData;
                    break;
                case 'CAP:MSGTYPE':
                    $parsedAlert['capMsgType'] = $elementData;
                    break;
                case 'CAP:CATEGORY':
                    $parsedAlert['capCategory'] = $elementData;
                    break;
                case 'CAP:URGENCY':
                    $parsedAlert['capUrgencyExpected'] = $elementData;
                    break;
                case 'CAP:SEVERITY':
                    $parsedAlert['capSeverity'] = $elementData;
                    break;
                case 'CAP:CERTAINTY':
                    $parsedAlert['capCertainty'] = $elementData;
                    break;
                case 'CAP:AREADESC':
                    $parsedAlert['capAreaDesc'] = $elementData;
                    break;
                case 'CAP:POLYGON':
                    $capPolygonString = $elementData;
                    $parsedAlert['capPolygon'] = explode(' ', $capPolygonString);
                    break;
                case 'CAP:GEOCODE':
                    $geoArray = array();

                    // parse into simple array
                    foreach ($element['children'] as $geo) {
                        if (isset($geo['tagData'])) {
                            $geoArray[] = $geo['tagData'];
                        }
                    }

                    $geoLocArray = $this->parseGeoArray($geoArray);
                    $parsedAlert['capGeoString'] = implode(', ', $geoArray);
                    $parsedAlert['capGeo'] = $geoLocArray;
                    break;
                case 'CAP:PARAMETER':
                    // It appears only vtec is currently stored here
                    if (isset($element['children'][1]['tagData'])) {
                        $parsedAlert['vtec'] = $element['children'][1]['tagData'];
                    }
                    break;
            }

            $parsedAlert['idKey'] = $this->generateIdKey($parsedAlert['idString']);

        }

        return $parsedAlert;
    }

    protected function parseGeoArray(array $geoArray): array
    {
        // organize array by format type
        $locationFormatTypes = array(
            'FIPS6',
            'UGC',
        );

        $currentLocationKey = 'null';
        $geoLocArray = array();

        foreach ($geoArray as $geoLoc) {
            if (in_array($geoLoc, $locationFormatTypes)) {
                $currentLocationKey = $geoLoc;
                $geoLocArray[$geoLoc] = array();
            } else {
                $geoLocArray[$currentLocationKey] = explode(' ', $geoLoc);
            }
        }

        return $geoLocArray;
    }

    protected function generateIdKey(string $idString): string
    {
        // idString contains important data in it as well.
        // Use it to generate a unique key for the alert.
        //
        // Example:
        //    alerts.weather.gov/cap/wwacapget.php?x=AK12539092A414.WinterWeatherAdvisory.125390A09AB0AK.AFGWSWNSB.a59f94b5da45867f6f45272a36df61cc
        //
        // The pieces of idString appears to be
        // 0. State abrev + some strange timestamp format
        // 1. Type
        // 2. Another timestamp with state abrev.
        // 3. ??
        // 4. Hash of some data (32 bit)
        //
        // Since 0,1,2, and 3 aren't unique on their own, but it looks like 4 is, I'll plan on using 0 and 4 just to be sure.

        $idParts = explode('=', $idString);
        $idSplit = explode('.', $idParts[1]);
        $idKey = $idSplit[0] . '.' . $idSplit[4];

        return $idKey;
    }

}
