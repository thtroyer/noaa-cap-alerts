<?php

namespace NoaaCapParser;

use NoaaCapParser\Repository\Model\NoaaAlertManager;
use NoaaCapParser\Repository\Parser\IndexParser;
use NoaaCapParser\Repository\Parser\XmlParser;
use NoaaCapParser\Repository\XmlProvider\DownloaderProvider;
use Pimple\Container;

class Dependencies extends Container
{
    protected $container;

    function __construct()
    {
        parent::__construct();

        $this['NoaaAlertManager'] = function ($c) {
            return new NoaaAlertManager($c['DownloaderProvider'], $c['IndexParser']);
        };

        $this['DownloaderProvider'] = function ($c) {
            return new DownloaderProvider();
        };

        $this['IndexParser'] = function ($c) {
            return new IndexParser($c['XmlParser']);
        };

        $this['XmlParser'] = function ($c) {
            return new XmlParser();
        };

        $this['DownloaderProvider'] = function ($c) {
            return new DownloaderProvider();
        };
    }
}


