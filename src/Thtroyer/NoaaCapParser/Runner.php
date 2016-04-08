<?php

namespace Thtroyer\NoaaCapParser;

use Thtroyer\NoaaCapParser\Utilities\XmlParser;
use Thtroyer\NoaaCapParser\NoaaCapParser;

class Runner
{
    protected $noaaCapParser;

    function __construct($noaaCapParser = null, $xmlParser = null)
    {
        $this->noaaCapParser = $noaaCapParser;

        if($xmlParser === null) {
            $xmlParser = new XmlParser();
        }

        if($noaaCapParser === null) {
            $this->noaaCapParser = new NoaaCapParser($xmlParser);
        }
    }


    public function run()
    {

        $xml = file_get_contents("http://alerts.weather.gov/cap/us.php?x=0");

        $alertArray = $this->noaaCapParser->parseFromXml($xml);

        print_r($alertArray);

    }

}

