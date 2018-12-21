<?php

namespace MetrcApi\Models;

class PackageFinish extends ApiObject
{
    /**
     * @var string
     */
    public $label;

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
     * @return \DateTimeInterface
     */
    public function getActualDate(): \DateTimeInterface
    {
        return $this->actualDate;
    }

    /**
     * @param \DateTimeInterface $actualDate
     */
    public function setActualDate(\DateTimeInterface $actualDate): void
    {
        $this->actualDate = $actualDate;
    }

    public function toArray()
    {
        return [
            'Label' => $this->getLabel(),
            'ActualDate' => $this->getActualDate()->format('Y-m-d')
        ];
    }
}