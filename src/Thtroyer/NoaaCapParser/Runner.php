<?php

namespace Thtroyer\NoaaCapParser;

use Thtroyer\NoaaCapParser\Utilities\XmlParser;
use Thtroyer\NoaaCapParser\NoaaCapParser;

class Runner
{
    protected $xmlParser;
    protected $noaaCapParser;

    function __construct($xmlParser = null, $noaaCapParser = null)
    {
        $this->xmlParser = $xmlParser;
        $this->noaaCapParser = $noaaCapParser;

        if($xmlParser === null) {
            $this->xmlParser = new XmlParser();
        }

        if($noaaCapParser === null) {
            $this->noaaCapParser = new NoaaCapParser();
        }
    }


    public function run()
    {

        $xml = file_get_contents("http://alerts.weather.gov/cap/us.php?x=0");

        $rawDataArray = $this->xmlParser->getArrayFromXml($xml);
        $alertDataArray = $rawDataArray[0]['children'];
        $alertArray = $this->noaaCapParser->parse($alertDataArray);

        print_r($alertArray);

    }

}

