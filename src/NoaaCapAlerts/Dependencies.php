<?php

namespace NoaaCapAlerts;

use NoaaCapAlerts\Model\NoaaAlertFactory;
use NoaaCapAlerts\Model\Polygon\PolygonFactory;
use NoaaCapAlerts\Parser\NoaaIndexParser;
use NoaaCapAlerts\Parser\XmlParser;
use NoaaCapAlerts\XmlProvider\XmlProviderFactory;
use Pimple\Container;

class Dependencies extends Container
{
    protected $container;

    public function __construct()
    {
        parent::__construct();

        $this['LocalFile'] = getenv("NoaaLocalFilePath");

        $this['NoaaAlertManager'] = function ($c) {
            return new NoaaAlertFactory($c['XmlProvider'], $c['IndexParser'], $c['PolygonFactory']);
        };

        $this['XmlProvider'] = function ($c) {
            return $c['XmlProviderFactory']->getXmlProvider();
        };

        $this['XmlProviderFactory'] = function ($c) {
            return new XmlProviderFactory($c['LocalFile']);
        };

        $this['PolygonFactory'] = function ($c) {
            return new PolygonFactory();
        };

        $this['IndexParser'] = function ($c) {
            return new NoaaIndexParser($c['XmlParser']);
        };

        $this['XmlParser'] = function ($c) {
            return new XmlParser();
        };
    }
}


