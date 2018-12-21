<?php

namespace MetrcApi\Models;

class Item extends ApiObject
{
    /**
     * @var int|null
     */
    public $id = null;

    /**
     * @var string
     */
    public $itemCategory;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $unitOfMeasure;

    /**
     * @var string|null
     */
    public $strain = null;

    /**
     * @var string|null
     */
    public $itemBrand = null;

    /**
     * @var float|null
     */
    public $unitCbdPercent = null;

    /**
     * @var float|null
     */
    public $unitCbdContent = null;

    /**
     * @var string|null
     */
    public $unitCbdContentUnitOfMeasure = null;

    /**
     * @var float|null
     */
    public $unitThcPercent = null;

    /**
     * @var float|null
     */
    public $unitThcContent = null;

    /**
     * @var string|null
     */
    public $unitThcContentUnitOfMeasure = null;

    /**
     * @var float|null
     */
    public $unitWeight = null;

    /**
     * @var string|null
     */
    public $unitWeightUnitOfMeasure = null;

    /**
     * @var float|null
     */
    public $unitVolume = null;

    /**
     * @var string|null
     */
    public $unitVolumeUnitOfMeasure = null;

    /**
     * @var null
     */
    public $servingSize = null;

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
    public function getItemCategory(): string
    {
        return $this->itemCategory;
    }

    /**
     * @param string $itemCategory
     */
    public function setItemCategory(string $itemCategory): void
    {
        $this->itemCategory = $itemCategory;
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
     * @return string|null
     */
    public function getStrain(): ?string
    {
        return $this->strain;
    }

    /**
     * @param string|null $strain
     */
    public function setStrain(?string $strain): void
    {
        $this->strain = $strain;
    }

    /**
     * @return string|null
     */
    public function getItemBrand(): ?string
    {
        return $this->itemBrand;
    }

    /**
     * @param string|null $itemBrand
     */
    public function setItemBrand(?string $itemBrand): void
    {
        $this->itemBrand = $itemBrand;
    }

    /**
     * @return float|null
     */
    public function getUnitCbdPercent(): ?float
    {
        return $this->unitCbdPercent;
    }

    /**
     * @param float|null $unitCbdPercent
     */
    public function setUnitCbdPercent(?float $unitCbdPercent): void
    {
        $this->unitCbdPercent = $unitCbdPercent;
    }

    /**
     * @return float|null
     */
    public function getUnitCbdContent(): ?float
    {
        return $this->unitCbdContent;
    }

    /**
     * @param float|null $unitCbdContent
     */
    public function setUnitCbdContent(?float $unitCbdContent): void
    {
        $this->unitCbdContent = $unitCbdContent;
    }

    /**
     * @return string|null
     */
    public function getUnitCbdContentUnitOfMeasure(): ?string
    {
        return $this->unitCbdContentUnitOfMeasure;
    }

    /**
     * @param string|null $unitCbdContentUnitOfMeasure
     */
    public function setUnitCbdContentUnitOfMeasure(?string $unitCbdContentUnitOfMeasure): void
    {
        $this->unitCbdContentUnitOfMeasure = $unitCbdContentUnitOfMeasure;
    }

    /**
     * @return float|null
     */
    public function getUnitThcPercent(): ?float
    {
        return $this->unitThcPercent;
    }

    /**
     * @param float|null $unitThcPercent
     */
    public function setUnitThcPercent(?float $unitThcPercent): void
    {
        $this->unitThcPercent = $unitThcPercent;
    }

    /**
     * @return float|null
     */
    public function getUnitThcContent(): ?float
    {
        return $this->unitThcContent;
    }

    /**
     * @param float|null $unitThcContent
     */
    public function setUnitThcContent(?float $unitThcContent): void
    {
        $this->unitThcContent = $unitThcContent;
    }

    /**
     * @return string|null
     */
    public function getUnitThcContentUnitOfMeasure(): ?string
    {
        return $this->unitThcContentUnitOfMeasure;
    }

    /**
     * @param string|null $unitThcContentUnitOfMeasure
     */
    public function setUnitThcContentUnitOfMeasure(?string $unitThcContentUnitOfMeasure): void
    {
        $this->unitThcContentUnitOfMeasure = $unitThcContentUnitOfMeasure;
    }

    /**
     * @return float|null
     */
    public function getUnitWeight(): ?float
    {
        return $this->unitWeight;
    }

    /**
     * @param float|null $unitWeight
     */
    public function setUnitWeight(?float $unitWeight): void
    {
        $this->unitWeight = $unitWeight;
    }

    /**
     * @return string|null
     */
    public function getUnitWeightUnitOfMeasure(): ?string
    {
        return $this->unitWeightUnitOfMeasure;
    }

    /**
     * @param string|null $unitWeightUnitOfMeasure
     */
    public function setUnitWeightUnitOfMeasure(?string $unitWeightUnitOfMeasure): void
    {
        $this->unitWeightUnitOfMeasure = $unitWeightUnitOfMeasure;
    }

    /**
     * @return float|null
     */
    public function getUnitVolume(): ?float
    {
        return $this->unitVolume;
    }

    /**
     * @param float|null $unitVolume
     */
    public function setUnitVolume(?float $unitVolume): void
    {
        $this->unitVolume = $unitVolume;
    }

    /**
     * @return string|null
     */
    public function getUnitVolumeUnitOfMeasure(): ?string
    {
        return $this->unitVolumeUnitOfMeasure;
    }

    /**
     * @param string|null $unitVolumeUnitOfMeasure
     */
    public function setUnitVolumeUnitOfMeasure(?string $unitVolumeUnitOfMeasure): void
    {
        $this->unitVolumeUnitOfMeasure = $unitVolumeUnitOfMeasure;
    }

    /**
     * @return null
     */
    public function getServingSize()
    {
        return $this->servingSize;
    }

    /**
     * @param null $servingSize
     */
    public function setServingSize($servingSize): void
    {
        $this->servingSize = $servingSize;
    }

    public function toArray()
    {
        return [
            'Id' => $this->getId(),
            'ItemCategory' => $this->getItemCategory(),
            'Name' => $this->getName(),
            'UnitOfMeasure' => $this->getUnitOfMeasure(),
            'Strain' => $this->getStrain(),
            'ItemBrand' => $this->getItemBrand(),
            'AdministrationMethod' => null,
            'UnitCbdPercent' => $this->getUnitCbdPercent(),
            'UnitCbdContent' => $this->getUnitCbdContent(),
            'UnitCbdContentUnitOfMeasure' => $this->getUnitCbdContentUnitOfMeasure(),
            'UnitThcPercent' => $this->getUnitThcPercent(),
            'UnitThcContent' => $this->getUnitThcContent(),
            'UnitThcContentUnitOfMeasure' => $this->getUnitThcContentUnitOfMeasure(),
            'UnitVolume' => $this->getUnitVolume(),
            'UnitWeight' => $this->getUnitWeight(),
            'UnitWeightUnitOfMeasure' => $this->getUnitVolumeUnitOfMeasure(),
            'ServingSize' => $this->getServingSize(),
            'SupplyDurationDays' => null, // no examples provided in documentation
            'Ingredients' => null // no examples provided in documentation
        ];
    }

}