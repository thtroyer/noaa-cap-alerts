<?php

namespace NoaaCapAlerts\Tests\Utilities;

use NoaaCapAlerts\Repository\Parser\XmlParser;
use NoaaCapAlerts\Exceptions\XmlParseException;

class XmlParserTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider xmlInputAndExpectedResults
     */
    public function testParseFromXml($testXml = '', $expectedResult = '')
    {
        $xmlParser = new XmlParser();

        $result = $xmlParser->getArrayFromXml($testXml);

        $this->assertEquals($expectedResult, $result);
    }

    public function xmlInputAndExpectedResults()
    {
        return array(
            array(
                'testXml' => "<xml><tag><childTag>asd</childTag></tag></xml>",
                'expectedResult' => array(
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
                ),
            ),
            array(
                'testXml' => "<tag1 attribute=\"att\"><tag2>val</tag2></tag1>",
                'expectedResult' => array(
                    array(
                        'name' => 'TAG1',
                        'attrs' => array(
                            'ATTRIBUTE' => 'att',
                        ),
                        'children' => array(
                            array(
                                'name' => 'TAG2',
                                'attrs' => array(),
                                'tagData' => 'val',
                            ),
                        ),
                    ),
                ),
            ),
            array(
                'testXml' => "<tag1 attribute=\"att\"><tag2>val</tag2><tag3>val2</tag3></tag1>",
                'expectedResult' => array(
                    array(
                        'name' => 'TAG1',
                        'attrs' => array(
                            'ATTRIBUTE' => 'att',
                        ),
                        'children' => array(
                            array(
                                'name' => 'TAG2',
                                'attrs' => array(),
                                'tagData' => 'val',
                            ),
                            array(
                                'name' => 'TAG3',
                                'attrs' => array(),
                                'tagData' => 'val2',
                            ),
                        ),
                    ),
                ),
            ),
        );
    }

    public function testXmlParseException()
    {
        $this->expectException(XmlParseException::class);

        $testXml = "
            <<asd,<dim
        ";

        $xmlParser = new XmlParser();
        $result = $xmlParser->getArrayFromXml($testXml);

    }
}
