<?php

namespace MetrcApi\Models;

class PackageAdjustment extends ApiObject
{
    /**
     * @var string
     */
    public $label;

    /**
     * @var float
     */
    public $quantity;

    /**
     * @var string
     */
    public $unitOfMeasure;

    /**
     * @var string
     */
    public $adjustmentReason;

    /**
     * @var string|null
     */
    public $reasonNote;

    /**
     * @var \DateTimeInterface
     */
    public $adjustmentDate;

    public function __construct()
    {
        $this->adjustmentDate = new \DateTime();
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
     * @return float
     */
    public function getQuantity(): float
    {
        return $this->quantity;
    }

    /**
     * @param float $quantity
     */
    public function setQuantity(float $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getUnitOfMeasure(): string
    {
        return $this->unitOfMeasure;
    }

    /**
     * @param string $unitOfMeasure
     */
    public function setUnitOfMeasure(string $unitOfMeasure): void
    {
        $this->unitOfMeasure = $unitOfMeasure;
    }

    /**
     * @return string
     */
    public function getAdjustmentReason(): string
    {
        return $this->adjustmentReason;
    }

    /**
     * @param string $adjustmentReason
     */
    public function setAdjustmentReason(string $adjustmentReason): void
    {
        $this->adjustmentReason = $adjustmentReason;
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

    /**
     * @return \DateTimeInterface
     */
    public function getAdjustmentDate(): \DateTimeInterface
    {
        return $this->adjustmentDate;
    }

    /**
     * @param \DateTimeInterface $adjustmentDate
     */
    public function setAdjustmentDate(\DateTimeInterface $adjustmentDate): void
    {
        $this->adjustmentDate = $adjustmentDate;
    }

    public function toArray()
    {
        return [
            'Label' => $this->getLabel(),
            'Quantity' => $this->getQuantity(),
            'UnitOfMeasure' => $this->getUnitOfMeasure(),
            'AdjustmentReason' => $this->getAdjustmentReason(),
            'AdjustmentDate' => $this->getAdjustmentDate()->format('Y-m-d'),
            'ReasonNote' => $this->getReasonNote()
        ];
    }
}