<?php

namespace MetrcApi\Models;

use MetrcApi\Exception\InvalidMetrcResponseException;

class HarvestWaste extends ApiObject
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $unitOfWeight;

    /**
     * @var float
     */
    public $wasteWeight;

    /**
     * @var \DateTimeInterface
     */
    public $actualDate;

    public function __construct()
    {
        $this->actualDate = new \DateTime();
    }

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
    public function getUnitOfWeight(): string
    {
        return $this->unitOfWeight;
    }

    /**
     * @param string $unitOfWeight
     */
    public function setUnitOfWeight(string $unitOfWeight): void
    {
        $this->unitOfWeight = $unitOfWeight;
    }

    /**
     * @return float
     */
    public function getWasteWeight(): float
    {
        return $this->wasteWeight;
    }

    /**
     * @param float $wasteWeight
     */
    public function setWasteWeight(float $wasteWeight): void
    {
        $this->wasteWeight = $wasteWeight;
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

    public function toArray()
    {
        return [
            'Id' => $this->getId(),
            'UnitOfWeight' => $this->getUnitOfWeight(),
            'WasteWeight' => $this->getWasteWeight(),
            'ActualDate' => $this->getActualDate()->format('Y-m-d')
        ];
    }
}