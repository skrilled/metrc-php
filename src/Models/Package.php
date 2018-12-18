<?php

namespace MetrcApi\Models;

use MetrcApi\Exception\InvalidMetrcResponseException;

class Package extends ApiObject
{
    /**
     * @var null|string
     */
    public $id = null;

    /**
     * @var string
     */
    public $tag;

    /**
     * @var string
     */
    public $room = null;

    /**
     * @var string
     */
    public $item;

    /**
     * @var float
     */
    public $quantity = 0.00;

    /**
     * @var string
     */
    public $unitOfMeasure;

    /**
     * @var string
     */
    public $patientLicenseNumber;

    /**
     * @var bool
     */
    public $isProductionBatch = false;

    /**
     * @var string|null
     */
    public $productionBatchNumber = null;

    /**
     * @var bool
     */
    public $productRequiresRemediation = false;

    /**
     * @var \DateTimeInterface
     */
    public $actualDate;

    /**
     * @var array
     */
    public $ingredients = array();

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     */
    public function setTag(string $tag): void
    {
        $this->tag = $tag;
    }

    /**
     * @return string
     */
    public function getRoom(): string
    {
        return $this->room;
    }

    /**
     * @param string $room
     */
    public function setRoom(string $room): void
    {
        $this->room = $room;
    }

    /**
     * @return string
     */
    public function getItem(): string
    {
        return $this->item;
    }

    /**
     * @param string $item
     */
    public function setItem(string $item): void
    {
        $this->item = $item;
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
     * @return bool
     */
    public function isProductionBatch(): bool
    {
        return $this->isProductionBatch;
    }

    /**
     * @param bool $isProductionBatch
     */
    public function setIsProductionBatch(bool $isProductionBatch): void
    {
        $this->isProductionBatch = $isProductionBatch;
    }

    /**
     * @return string|null
     */
    public function getProductionBatchNumber(): ?string
    {
        return $this->productionBatchNumber;
    }

    /**
     * @param string|null $productionBatchNumber
     */
    public function setProductionBatchNumber(?string $productionBatchNumber): void
    {
        $this->productionBatchNumber = $productionBatchNumber;
    }

    /**
     * @return bool
     */
    public function isProductRequiresRemediation(): bool
    {
        return $this->productRequiresRemediation;
    }

    /**
     * @param bool $productRequiresRemediation
     */
    public function setProductRequiresRemediation(bool $productRequiresRemediation): void
    {
        $this->productRequiresRemediation = $productRequiresRemediation;
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
     * @return array
     */
    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    /**
     * @param array $ingredients
     */
    public function setIngredients(array $ingredients): void
    {
        $this->ingredients = $ingredients;
    }

    public function __toArray()
    {
        return [
            'Tag' => $this->getTag(),
            "Room" => $this->getRoom(),
            "Item" => $this->getItem(),
            "Quantity" => $this->getQuantity(),
            "UnitOfMeasure" => $this->getUnitOfMeasure(),
            "PatientLicenseNumber" => $this->getPatientLicenseNumber(),
            "IsProductionBatch" => $this->isProductionBatch(),
            "ProductionBatchNumber" => $this->getProductionBatchNumber(),
            "ProductRequiresRemediation" => $this->isProductRequiresRemediation(),
            "ActualDate" => $this->getActualDate()->format(\DateTime::ISO8601),
            'Ingredients' => [
                $this->getIngredients()
            ]
        ];
    }

}