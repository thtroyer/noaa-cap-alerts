<?php

namespace NoaaCapParser\Tests\Utilities;

use NoaaCapParser\Utilities\XmlParser;

class XmlParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParseFromXml()
    {
        $testXml = "
            <xml><tag><childTag>asd</childTag></tag></xml>
        ";

        $expectedResult = array(
            array(
                'name' => 'XML',
                'attrs' => array(),
                'children' => array(
                    array(
                        'name' => 'TAG',
                        'attrs' => array(),
                        'children' => array(
                            array(
                                'name' => 'CHILDTAG',
                                'attrs' => array(),
                                'tagData' => 'asd',
                            ),
                        ),
                    ),
                ),
            ),
        );

        $xmlParser = new XmlParser();

        $result = $xmlParser->getArrayFromXml($testXml);

        $this->assertEquals($expectedResult, $result);
    }
}
