<?php

namespace MetrcApi\Models;

use MetrcApi\Exception\InvalidMetrcResponseException;

class PlantBatchPlanting extends ApiObject
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $type;

    /**
     * @var int
     */
    public $count = 0;

    /**
     * @var string
     */
    public $strain;

    /**
     * @var string|null
     */
    public $room;

    /**
     * @var string
     */
    public $patientLicenseNumber;

    /**
     * @var \DateTimeInterface
     */
    public $actualDate;

    public function __construct()
    {
        $this->actualDate = new \DateTime();
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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
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
    public function getStrain(): string
    {
        return $this->strain;
    }

    /**
     * @param string $strain
     */
    public function setStrain(string $strain): void
    {
        $this->strain = $strain;
    }

    /**
     * @return string|null
     */
    public function getRoom(): ?string
    {
        return $this->room;
    }

    /**
     * @param string|null $room
     */
    public function setRoom(?string $room): void
    {
        $this->room = $room;
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
    public function getActualDate(): \DateTimeInterface
    {
        return $this->actualDate;
    }

    /**
     * @param \DateTimeInterface|string $actualDate
     * @throws \Exception
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

    public function toArray()
    {
        return [
            'Name' => $this->getName(),
            'Type' => $this->getType(),
            'Count' => $this->getCount(),
            'Strain' => $this->getStrain(),
            'PatientLicenseNumber' => $this->getPatientLicenseNumber(),
            'ActualDate' => $this->actualDate->format('Y-m-d')
        ];
    }
}