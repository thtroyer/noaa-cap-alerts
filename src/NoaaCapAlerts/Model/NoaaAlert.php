<?php

namespace NoaaCapAlerts\Model;

use NoaaCapAlerts\Model\Polygon\Polygon;

class NoaaAlert
{
    protected string $idString;
    protected string $idKey;
    protected \DateTime $updatedTime;
    protected \DateTime $publishedTime;
    protected string $authorName;
    protected string $title;
    protected string $link;
    protected string $summary;
    protected string $capEvent;
    protected ?\DateTime $capEffectiveTime;
    protected ?\DateTime $capExpiresTime;
    protected string $capStatus;
    protected string $capMsgType;
    protected string $capCategory;
    protected string $capUrgencyExpected;
    protected string $capSeverity;
    protected string $capCertainty;
    protected string $capAreaDesc;
    protected array $capPolygon;
    protected array $capGeo;
    protected string $capGeoString;
    protected string $vtec;
    protected Polygon $polygon;

    public function __construct(string $idString,
                                string $idKey,
                                \DateTime $updatedTime,
                                \DateTime $publishedTime,
                                string $authorName,
                                string $title,
                                string $link,
                                string $summary,
                                string $capEvent,
                                ? \DateTime $capEffectiveTime,
                                ? \DateTime $capExpiresTime,
                                string $capStatus,
                                string $capMsgType,
                                string $capCategory,
                                string $capUrgencyExpected,
                                string $capSeverity,
                                string $capCertainty,
                                string $capAreaDesc,
                                array $capPolygon,
                                array $capGeo,
                                string $capGeoString,
                                string $vtec,
                                ?Polygon $polygon = null)
    {
        $this->idString = $idString;
        $this->idKey = $idKey;
        $this->updatedTime = $updatedTime;
        $this->publishedTime = $publishedTime;
        $this->authorName = $authorName;
        $this->title = $title;
        $this->link = $link;
        $this->summary = $summary;
        $this->capEvent = $capEvent;
        $this->capEffectiveTime = $capEffectiveTime;
        $this->capExpiresTime = $capExpiresTime;
        $this->capStatus = $capStatus;
        $this->capMsgType = $capMsgType;
        $this->capCategory = $capCategory;
        $this->capUrgencyExpected = $capUrgencyExpected;
        $this->capSeverity = $capSeverity;
        $this->capCertainty = $capCertainty;
        $this->capAreaDesc = $capAreaDesc;
        $this->capPolygon = $capPolygon;
        $this->capGeo = $capGeo;
        $this->capGeoString = $capGeoString;
        $this->vtec = $vtec;

        if ($polygon !== null) {
            $this->polygon = $polygon;
        } else {
            $this->polygon = new Polygon();
        }
    }

    public function toArray(): array
    {
        return [
            'idString' => $this->idString,
            'idKey' => $this->idKey,
            'updatedTime' => $this->updatedTime,
            'publishedTime' => $this->publishedTime,
            'authorName' => $this->authorName,
            'title' => $this->title,
            'link' => $this->link,
            'summary' => $this->summary,
            'capEvent' => $this->capEvent,
            'capEffectiveTime' => $this->capEffectiveTime,
            'capExpiresTime' => $this->capExpiresTime,
            'capStatus' => $this->capStatus,
            'capMsgType' => $this->capMsgType,
            'capCategory' => $this->capCategory,
            'capUrgencyExpected' => $this->capUrgencyExpected,
            'capSeverity' => $this->capSeverity,
            'capCertainty' => $this->capCertainty,
            'capAreaDesc' => $this->capAreaDesc,
            'capPolygon' => $this->capPolygon,
            'capGeo' => $this->capGeo,
            'capGeoString' => $this->capGeoString,
            'vtec' => $this->vtec,
        ];
    }

    public function getIdString(): string
    {
        return $this->idString;
    }

    public function getIdKey(): string
    {
        return $this->idKey;
    }

    public function getUpdatedTime(): \DateTime
    {
        return $this->updatedTime;
    }

    public function getPublishedTime(): \DateTime
    {
        return $this->publishedTime;
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getSummary(): string
    {
        return $this->summary;
    }

    public function getCapEvent(): string
    {
        return $this->capEvent;
    }

    public function getCapEffectiveTime(): ?\DateTime
    {
        return $this->capEffectiveTime;
    }

    public function getCapExpiresTime(): ?\DateTime
    {
        return $this->capExpiresTime;
    }

    public function getCapStatus(): string
    {
        return $this->capStatus;
    }

    public function getCapMsgType(): string
    {
        return $this->capMsgType;
    }

    public function getCapCategory(): string
    {
        return $this->capCategory;
    }

    public function getCapUrgencyExpected(): string
    {
        return $this->capUrgencyExpected;
    }

    public function getCapSeverity(): string
    {
        return $this->capSeverity;
    }

    public function getCapCertainty(): string
    {
        return $this->capCertainty;
    }

    public function getCapAreaDesc(): string
    {
        return $this->capAreaDesc;
    }

    public function getCapPolygon(): array
    {
        return $this->capPolygon;
    }

    public function getCapGeo(): array
    {
        return $this->capGeo;
    }

    public function getCapGeoString(): string
    {
        return $this->capGeoString;
    }

    public function getVtec(): string
    {
        return $this->vtec;
    }
}