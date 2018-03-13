<?php

namespace NoaaCapParser\Repository\Parser;

class DetailParser
{
    protected $xmlParser;

    function __construct(XmlParser $xmlParser)
    {
        $this->xmlParser = $xmlParser;
    }

    public function parse($xml)
    {
        //todo
    }
}
