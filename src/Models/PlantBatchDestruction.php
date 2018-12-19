<?php

namespace MetrcApi\Models;

use MetrcApi\Exception\InvalidMetrcResponseException;

class PlantBatchDestruction extends ApiObject
{
    /**
     * @var string
     */
    public $plantBatch;

    /**
     * @var int
     */
    public $count = 0;

    /**
     * @var string
     */
    public $reasonNote;

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
    public function getPlantBatch(): string
    {
        return $this->plantBatch;
    }

    /**
     * @param string $plantBatch
     */
    public function setPlantBatch(string $plantBatch): void
    {
        $this->plantBatch = $plantBatch;
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
    public function getReasonNote(): string
    {
        return $this->reasonNote;
    }

    /**
     * @param string $reasonNote
     */
    public function setReasonNote(string $reasonNote): void
    {
        $this->reasonNote = $reasonNote;
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
            'PlantBatch' => $this->getName(),
            'Count' => $this->getCount(),
            'ReasonNote' => $this->getReasonNote(),
            'ActualDate' => $this->actualDate->format('Y-m-d')
        ];
    }
}