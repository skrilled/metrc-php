<?php

namespace MetrcApi\Models;

use MetrcApi\Exception\InvalidMetrcResponseException;

class LabTest extends ApiObject
{
    /**
     * @var string
     */
    public $label;

    /**
     * @var \DateTimeInterface
     */
    public $resultDate;

    /**
     * @var array
     */
    public $results = array();

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
    public function getResultDate(): \DateTimeInterface
    {
        return $this->resultDate;
    }

    /**
     * @param \DateTime|string $resultDate
     * @throws InvalidMetrcResponseException
     */
    public function setResultDate($resultDate): void
    {
        if(is_string($resultDate)) {
            $this->resultDate = new \DateTime($resultDate);
        } elseif($resultDate instanceof \DateTime) {
            $this->resultDate = $resultDate;
        } else {
            throw new InvalidMetrcResponseException('Unexpected Date Format: '.$resultDate);
        }
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param mixed $results
     */
    public function setResults($results): void
    {
        $this->results = [$results];
    }

    public function toArray()
    {
        return [
            'Label' => $this->getLabel(),
            'ResultDate' => $this->getResultDate()->format(\DateTime::ISO8601),
            'Results' => $this->getResults()
        ];
    }


}