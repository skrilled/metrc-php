<?php

namespace MetrcApi\Models;

use MetrcApi\Exception\InvalidMetrcResponseException;

class Plant extends ApiObject
{
    /**
     * @var null|int
     */
    public $id = null;

    /**
     * @var string
     */
    public $label;

    /**
     * @var string|null
     */
    public $room;

    /**
     * @var \DateTimeInterface
     */
    public $actualDate;

    /**
     * @var string|null
     */
    public $reasonNote;

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
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
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
     * @return string|null
     */
    public function getReasonNote(): ?string
    {
        return $this->reasonNote;
    }

    /**
     * @param string|null $reasonNote
     */
    public function setReasonNote(?string $reasonNote): void
    {
        $this->reasonNote = $reasonNote;
    }

    public function toArray()
    {
        return [
            'Id' => $this->getId(),
            'Label' => $this->getLabel(),
            'ReasonNote' => $this->getReasonNote(),
            'Room' => $this->getRoom(),
            'ActualDate' => $this->getActualDate()->format('Y-m-d')
        ];
    }
}