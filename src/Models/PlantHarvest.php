<?php

namespace MetrcApi\Models;

use MetrcApi\Exception\InvalidMetrcResponseException;

class PlantHarvest extends ApiObject
{
    /**
     * @var null|int
     */
    public $id = null;

    /**
     * @var string
     */
    public $plant;

    /**
     * @var string|null
     */
    public $room;

    /**
     * @var string|null
     */
    public $patientLicenseNumber;

    /**
     * @var \DateTimeInterface
     */
    public $actualDate;

    /**
     * @var float
     */
    public $weight;

    /**
     * @var string|null
     */
    public $unitOfWeight;

    /**
     * @var string|null
     */
    public $harvestName;

    public function __construct()
    {
        $this->actualDate = new \DateTime();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getPlant(): string
    {
        return $this->plant;
    }

    /**
     * @param string $plant
     */
    public function setPlant(string $plant): void
    {
        $this->plant = $plant;
    }

    /**
     * @return string|null
     */
    public function getPatientLicenseNumber(): ?string
    {
        return $this->patientLicenseNumber;
    }

    /**
     * @param string|null $patientLicenseNumber
     */
    public function setPatientLicenseNumber(?string $patientLicenseNumber): void
    {
        $this->patientLicenseNumber = $patientLicenseNumber;
    }

    /**
     * @return string
     */
    public function getRoom(): ?string
    {
        return $this->room;
    }

    /**
     * @param string $room
     */
    public function setRoom(?string $room): void
    {
        $this->room = $room;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getActualDate(): \DateTimeInterface
    {
        return $this->actualDate;
    }

    /**
     * @param \DateTimeInterface|string $actualDate
     * @throws InvalidMetrcResponseException
     */
    public function setActualDate($actualDate): void
    {
        if(is_string($actualDate)) {
            $this->actualDate = new \DateTime($actualDate);
        } elseif($actualDate instanceof \DateTime) {
            $this->actualDate = $actualDate;
        } else {
            throw new InvalidMetrcResponseException('Unexpected Date Format: '.$actualDate);
        }
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     */
    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return string|null
     */
    public function getUnitOfWeight(): ?string
    {
        return $this->unitOfWeight;
    }

    /**
     * @param string|null $unitOfWeight
     */
    public function setUnitOfWeight(?string $unitOfWeight): void
    {
        $this->unitOfWeight = $unitOfWeight;
    }

    /**
     * @return string|null
     */
    public function getHarvestName(): ?string
    {
        return $this->harvestName;
    }

    /**
     * @param string|null $harvestName
     */
    public function setHarvestName(?string $harvestName): void
    {
        $this->harvestName = $harvestName;
    }

    public function toArray()
    {
        return [
            'Id' => $this->getId(),
            'Plant' => $this->getPlant(),
            'DryingRoom' => $this->getRoom(),
            'PatientLicenseNumber' => $this->getPatientLicenseNumber(),
            'HarvestName' => $this->getHarvestName(),
            'Weight' => $this->getWeight(),
            'UnitOfWeight' => $this->getUnitOfWeight(),
            'ActualDate' => $this->getActualDate()->format('Y-m-d')
        ];
    }
}