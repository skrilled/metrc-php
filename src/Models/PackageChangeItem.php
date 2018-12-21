<?php

namespace MetrcApi\Models;

class PackageChangeItem extends ApiObject
{
    /**
     * @var string
     */
    public $label;

    /**
     * string
     */
    public $item;

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
     * @return mixed
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param mixed $item
     */
    public function setItem($item): void
    {
        $this->item = $item;
    }

    public function toArray()
    {
        return [
            'Label' => $this->getLabel(),
            'Item' => $this->getItem()
        ];
    }
}