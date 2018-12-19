<?php

namespace MetrcApi\Models;

use MetrcApi\Exception\InvalidMetrcResponseException;

class PlantBatchPlantingGrowthPhase extends ApiObject
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $count = 0;

    /**
     * @var string
     */
    public $startingTag;

    /**
     * @var string
     */
    public $growthPhase;

    /**
     * @var string|null
     */
    public $newRoom;

    /**
     * @var string
     */
    public $patientLicenseNumber;

    /**
     * @var \DateTimeInterface
     */
    public $growthDate;

    public function __construct()
    {
        $this->growthDate = new \DateTime();
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
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return string
     */
    public function getStartingTag(): string
    {
        return $this->startingTag;
    }

    /**
     * @param string $startingTag
     */
    public function setStartingTag(string $startingTag): void
    {
        $this->startingTag = $startingTag;
    }

    /**
     * @return string
     */
    public function getGrowthPhase(): string
    {
        return $this->growthPhase;
    }

    /**
     * @param string $growthPhase
     */
    public function setGrowthPhase(string $growthPhase): void
    {
        $this->growthPhase = $growthPhase;
    }

    /**
     * @return string|null
     */
    public function getNewRoom(): ?string
    {
        return $this->newRoom;
    }

    /**
     * @param string|null $newRoom
     */
    public function setNewRoom(?string $newRoom): void
    {
        $this->newRoom = $newRoom;
    }

    /**
     * @return string
     */
    public function getPatientLicenseNumber(): string
    {
        return $this->patientLicenseNumber;
    }

    /**
     * @param string $patientLicenseNumber
     */
    public function setPatientLicenseNumber(string $patientLicenseNumber): void
    {
        $this->patientLicenseNumber = $patientLicenseNumber;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getGrowthDate(): \DateTimeInterface
    {
        return $this->growthDate;
    }

    /**
     * @param \DateTimeInterface|string $growthDate
     * @throws InvalidMetrcResponseException
     */
    public function setGrowthDate($growthDate): void
    {
        if(is_string($growthDate)) {
            $this->growthDate = new \DateTime($growthDate);
        } elseif($growthDate instanceof \DateTime) {
            $this->growthDate = $growthDate;
        } else {
            throw new InvalidMetrcResponseException('Unexpected Date Format: '.$growthDate);
        }
    }

    public function toArray()
    {
        return [
            'Name' => $this->getName(),
            'Count' => $this->getCount(),
            'StartingTag' => $this->getStartingTag(),
            'GrowthPhase' => $this->getGrowthPhase(),
            'NewRoom' => $this->getNewRoom(),
            'GrowthDate' => $this->growthDate->format('Y-m-d'),
            'PatientLicenseNumber' => $this->getPatientLicenseNumber()
        ];
    }
}