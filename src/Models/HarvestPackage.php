<?php

namespace MetrcApi\Models;

use MetrcApi\Exception\InvalidMetrcResponseException;

class HarvestPackage extends ApiObject
{
    /**
     * @var int
     */
    public $harvest;

    /**
     * @var string
     */
    public $tag;

    /**
     * @var string|null
     */
    public $room;

    /**
     * @var string
     */
    public $item;

    /**
     * @var float
     */
    public $weight;

    /**
     * @var string
     */
    public $unitOfWeight;

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
     * @var bool
     */
    public $remediateProduct = false;

    /**
     * @var string|null
     */
    public $remediationMethodId = null;

    /**
     * @var null
     */
    public $remediationDate = null;

    /**
     * @var null
     */
    public $remediationSteps = null;

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
    public function getHarvest(): int
    {
        return $this->harvest;
    }

    /**
     * @param int $harvest
     */
    public function setHarvest(int $harvest): void
    {
        $this->harvest = $harvest;
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
     * @return bool
     */
    public function isRemediateProduct(): bool
    {
        return $this->remediateProduct;
    }

    /**
     * @param bool $remediateProduct
     */
    public function setRemediateProduct(bool $remediateProduct): void
    {
        $this->remediateProduct = $remediateProduct;
    }

    /**
     * @return string|null
     */
    public function getRemediationMethodId(): ?string
    {
        return $this->remediationMethodId;
    }

    /**
     * @param string|null $remediationMethodId
     */
    public function setRemediationMethodId(?string $remediationMethodId): void
    {
        $this->remediationMethodId = $remediationMethodId;
    }

    /**
     * @return null
     */
    public function getRemediationDate()
    {
        return $this->remediationDate;
    }

    /**
     * @param null $remediationDate
     */
    public function setRemediationDate($remediationDate): void
    {
        $this->remediationDate = $remediationDate;
    }

    /**
     * @return null
     */
    public function getRemediationSteps()
    {
        return $this->remediationSteps;
    }

    /**
     * @param null $remediationSteps
     */
    public function setRemediationSteps($remediationSteps): void
    {
        $this->remediationSteps = $remediationSteps;
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
     * @throws InvalidMetrcResponseException
     */
    public function setActualDate(\DateTimeInterface $actualDate): void
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
            'Harvest' => $this->getHarvest(),
            'Tag' => $this->getTag(),
            'Room' => $this->getRoom(),
            'Item' => $this->getItem(),
            'Weight' => $this->getWeight(),
            'UnitOfWeight' => $this->getUnitOfWeight(),
            'PatientLicenseNumber' => $this->getPatientLicenseNumber(),
            'IsProductionBatch' => $this->isProductionBatch(),
            'ProductionBatchNumber' => $this->getProductionBatchNumber(),
            'ProductRequiresRemediation' => $this->isProductRequiresRemediation(),
            'RemediateProduct' => $this->isRemediateProduct(),
            'RemediationMethodId' => $this->getRemediationMethodId(),
            'RemediationDate' => $this->getRemediationDate(),
            'RemediationSteps' => $this->getRemediationSteps(),
            'ActualDate' => $this->actualDate->format('Y-m-d')
        ];
    }
}