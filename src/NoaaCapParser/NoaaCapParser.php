<?php

namespace NoaaCapParser;

use NoaaCapParser\Utilities\XmlParser;

/**
 * Class NoaaCapParser
 * @package NoaaCapParser
 */
class NoaaCapParser
{
    protected $xmlParser;
    protected $resultArray;

    /**
     * NoaaCapParser constructor.
     * @param XmlParser|null $xmlParser
     */
    function __construct(XmlParser $xmlParser = null)
    {
        $this->xmlParser = $xmlParser;

        if($xmlParser === null) {
            $this->xmlParser = new XmlParser();
        }
    }

    /**
     * @param string $xml
     * @return array
     */
    public function parseFromXml(string $xml) : array
    {
        // parse XML into an array of alerts
        $rawDataArray = $this->xmlParser->getArrayFromXml($xml);
        $alertDataArray = $rawDataArray[0]['children'];

        // Process each alert ("ENTRY")
        $resultArray = array();

        foreach($alertDataArray as $alert) {
            $parsedAlert = $this->parseAlert($alert);
            if($parsedAlert !== null) {
                $resultArray[] = $parsedAlert;
            }
        }

        $this->resultArray = $resultArray;

        return $resultArray;
    }

    /**
     * @return array
     */
    public function getResultArray() : array
    {
        return $this->resultArray;
    }

    /**
     * @param array $alert
     * @return array
     */
    protected function parseAlert(array $alert)
    {
        //set default attributes
        $idString = '';
        $updatedTime = '';
        $publishedTime = '';
        $elementData = '';
        $authorName = '';
        $title = '';
        $link = '';
        $summary = '';
        $capEvent = '';
        $capEffectiveTime = '';
        $capExpiresTime = '';
        $capStatus = '';
        $capMsgType = '';
        $capCategory = '';
        $capUrgencyExpected = '';
        $capSeverity = '';
        $capCertainty = '';
        $capAreaDesc = '';
        $capPolygon = '';
        $capGeo = array();
        $capGeoString = '';
        $capParameters = '';

        if(!isset($alert['name']) || $alert['name'] != 'ENTRY') {
            return null;
        }

        // Loop through attributes and set values
        foreach($alert['children'] as $element){
            $elementName = $element['name'];
            $elementAttrs = $element['attrs'];
            if(isset($element['tagData'])){
                $elementData = $element['tagData'];
            } else {
                $elementData = '';
            }

            switch($elementName){
                case 'ID':
                    $idString = $elementData;
                    break;
                case 'UPDATED':
                    $updatedDateTime = new \DateTime($elementData);
                    $updatedTime  = $updatedDateTime->format('Y-m-d H:i:s');
                    break;
                case 'PUBLISHED':
                    $publishedDateTime = new \DateTime($elementData);
                    $publishedTime = $publishedDateTime->format('Y-m-d H:i:s');
                    break;
                case 'AUTHOR':
                    $authorName = $element['children'][0]['tagData'];
                    break;
                case 'TITLE':
                    $title = $elementData;
                    break;
                case 'LINK':
                    $link = $elementAttrs['HREF'];
                    break;
                case 'SUMMARY':
                    $summary = $elementData;
                    break;
                case 'CAP:EVENT':
                    $capEvent = $elementData;
                    break;
                case 'CAP:EFFECTIVE':
                    $effectiveDateTime = new \DateTime($elementData);
                    $capEffectiveTime = $effectiveDateTime->format('Y-m-d H:i:s');
                    break;
                case 'CAP:EXPIRES':
                    $expiresDateTime = new \DateTime($elementData);
                    $capExpiresTime = $expiresDateTime->format('Y-m-d H:i:s');
                    break;
                case 'CAP:STATUS':
                    $capStatus = $elementData;
                    break;
                case 'CAP:MSGTYPE':
                    $capMsgType = $elementData;
                    break;
                case 'CAP:CATEGORY':
                    $capCategory = $elementData;
                    break;
                case 'CAP:URGENCY':
                    $capUrgencyExpected = $elementData;
                    break;
                case 'CAP:SEVERITY':
                    $capSeverity = $elementData;
                    break;
                case 'CAP:CERTAINTY':
                    $capCertainty = $elementData;
                    break;
                case 'CAP:AREADESC':
                    $capAreaDesc = $elementData;
                    break;
                case 'CAP:POLYGON':
                    $capPolygonString = $elementData;
                    $capPolygon = explode(' ', $capPolygonString);
                    break;
                case 'CAP:GEOCODE':
                    $geoArray = array();

                    // parse into simple array
                    foreach($element['children'] as $geo) {
                        if(isset($geo['tagData'])) {
                            $geoArray[] = $geo['tagData'];
                        }
                    }

                    $geoLocArray = $this->parseGeoArray($geoArray);
                    $capGeoString = implode(', ', $geoArray);
                    $capGeo = $geoLocArray;
                    break;
                case 'CAP:PARAMETERS':
                    $capParameters  = '';
                    $paramArray = array();
                    foreach($element['children'] as $param){
                        $paramArray[] = $param['tagData'];
                    }
                    $capParameters = implode(', ', $paramArray);
                    break;
            }

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

            $parsedAlert = array(
                'idString' => $idString,
                'idKey' => $idKey,
                'updatedTime' => $updatedTime,
                'publishedTime' => $publishedTime,
                'authorName' => $authorName,
                'title' => $title,
                'link' => $link,
                'summary' => $summary,
                'capEvent' => $capEvent,
                'capEffectiveTime' => $capEffectiveTime,
                'capExpiresTime' => $capExpiresTime,
                'capStatus' => $capStatus,
                'capMsgType' => $capMsgType,
                'capCategory' => $capCategory,
                'capUrgencyExpected' => $capUrgencyExpected,
                'capSeverity' => $capSeverity,
                'capCertainty' => $capCertainty,
                'capAreaDesc' => $capAreaDesc,
                'capPolygon' => $capPolygon,
                'capGeo' => $capGeo,
                'capGeoString' => $capGeoString,
                'capParameters' => $capParameters,
            );

        }

        return $parsedAlert;
    }

    /**
     * @param array $geoArray
     * @return array
     */
    protected function parseGeoArray(array $geoArray) : array
    {
        // organize array by format type
        $locationFormatTypes = array(
            'FIPS6',
            'UGC',
        );

        $currentLocationKey = 'null';
        $geoLocArray = array();

        foreach($geoArray as $geoLoc) {
            if(in_array($geoLoc, $locationFormatTypes)) {
                $currentLocationKey = $geoLoc;
                $geoLocArray[$geoLoc] = array();
            } else {
                $geoLocArray[$currentLocationKey] = explode(' ', $geoLoc);
            }
        }

        return $geoLocArray;
    }

}
