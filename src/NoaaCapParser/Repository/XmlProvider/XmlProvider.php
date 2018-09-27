<?php

namespace NoaaCapParser\Repository\XmlProvider;

interface XmlProvider
{
    public function getXml() : string;
}