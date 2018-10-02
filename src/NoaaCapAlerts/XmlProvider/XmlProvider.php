<?php

namespace NoaaCapAlerts\XmlProvider;

interface XmlProvider
{
    public function getXml(): string;
}