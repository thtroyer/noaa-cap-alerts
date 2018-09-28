<?php

namespace NoaaCapAlerts\Parser;

use NoaaCapAlerts\Exceptions\XmlParseException;

/**
 * Uses php's xml_parse to create a php array
 * from an XML string.
 */
class XmlParser {

    /** @var array  Array representation of the passed XML */
    protected $output;

    function __construct()
    {
        $this->output = array();
    }

    /**
     * @param $xml 
     * @return array
     */
    public function getArrayFromXml($xml)
    {
        $xmlParser = xml_parser_create();
        xml_set_object($xmlParser,$this);
        xml_set_element_handler($xmlParser, "tagOpen", "tagClosed");
        xml_set_character_data_handler($xmlParser, "tagData");

        $successfulParse = xml_parse($xmlParser, $xml, true);

        if($successfulParse === 0) {
            $errorString = xml_error_string(xml_get_error_code($xmlParser));
            $errorLine = xml_get_current_line_number($xmlParser);

            throw new XmlParseException("Error parsing XML: {$errorString} at line {$errorLine}.");
        }

        xml_parser_free($xmlParser);

        return $this->output;
    }

    protected function tagOpen($parser, $name, $attrs)
    {
        $tag = array(
            "name" => $name,
            "attrs" => $attrs
        ); 
        
        array_push($this->output,$tag);
    }

    protected function tagClosed($parser, $name)
    {
        $this->output[count($this->output) - 2]['children'][] = $this->output[count($this->output) - 1];

        array_pop($this->output);
    }

    protected function tagData($parser, $tagData)
    {
        $notWhitespace = !empty(trim($tagData));

        if($notWhitespace) {
            $this->output[count($this->output) - 1]['tagData'] = $tagData;
        }
    }
}
 
