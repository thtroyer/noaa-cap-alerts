<?php

namespace NoaaCapAlerts;

use NoaaCapAlerts\Model\NoaaAlertManager;
use NoaaCapAlerts\Parser\IndexParser;
use NoaaCapAlerts\Parser\XmlParser;
use NoaaCapAlerts\XmlProvider\XmlProviderFactory;
use Pimple\Container;

class Dependencies extends Container
{
    protected $container;

    function __construct()
    {
        parent::__construct();

        $this['LocalFile'] = getenv("NoaaLocalFilePath");

        $this['NoaaAlertManager'] = function ($c) {
            return new NoaaAlertManager($c['XmlProvider'], $c['IndexParser']);
        };

        $this['XmlProvider'] = function ($c) {
            return $c['XmlProviderFactory']->getXmlProvider();
        };

        $this['XmlProviderFactory'] = function ($c) {
            return new XmlProviderFactory($c['LocalFile']);
        };

        $this['IndexParser'] = function ($c) {
            return new IndexParser($c['XmlParser']);
        };

        $this['XmlParser'] = function ($c) {
            return new XmlParser();
        };
    }
}


