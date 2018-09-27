<?php

namespace NoaaCapAlerts\Repository\XmlProvider;

interface XmlProvider
{
    public function getXml() : string;
}