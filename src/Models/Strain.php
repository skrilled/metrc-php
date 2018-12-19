<?php

namespace MetrcApi\Models;

class Strain extends ApiObject
{
    /**
     * @var int
     */
    public $id = null;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $testingStatus;

    /**
     * @var float|null
     */
    public $thcLevel;

    /**
     * @var float|null
     */
    public $cbdLevel;

    /**
     * @var float|null
     */
    public $indicaPercentage;

    /**
     * @var float|null
     */
    public $sativaPercentage;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getTestingStatus(): string
    {
        return $this->testingStatus;
    }

    /**
     * @param string $testingStatus
     */
    public function setTestingStatus(string $testingStatus): void
    {
        $this->testingStatus = $testingStatus;
    }

    /**
     * @return float
     */
    public function getThcLevel(): ?float
    {
        return $this->thcLevel;
    }

    /**
     * @param float $thcLevel
     */
    public function setThcLevel(?float $thcLevel): void
    {
        $this->thcLevel = $thcLevel;
    }

    /**
     * @return float
     */
    public function getCbdLevel(): ?float
    {
        return $this->cbdLevel;
    }

    /**
     * @param float $cbdLevel
     */
    public function setCbdLevel(?float $cbdLevel): void
    {
        $this->cbdLevel = $cbdLevel;
    }

    /**
     * @return float
     */
    public function getIndicaPercentage(): ?float
    {
        return $this->indicaPercentage;
    }

    /**
     * @param float $indicaPercentage
     */
    public function setIndicaPercentage(?float $indicaPercentage): void
    {
        $this->indicaPercentage = $indicaPercentage;
    }

    /**
     * @return float
     */
    public function getSativaPercentage(): ?float
    {
        return $this->sativaPercentage;
    }

    /**
     * @param float $sativaPercentage
     */
    public function setSativaPercentage(?float $sativaPercentage): void
    {
        $this->sativaPercentage = $sativaPercentage;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'Id' => $this->id,
            'Name' => $this->name,
            "TestingStatus" => $this->testingStatus,
            "ThcLevel" => $this->thcLevel,
            "CbdLevel" => $this->cbdLevel,
            "IndicaPercentage" => $this->indicaPercentage,
            "SativaPercentage" => $this->sativaPercentage
        ];
    }
}