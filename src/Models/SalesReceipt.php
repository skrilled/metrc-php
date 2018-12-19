<?php

namespace MetrcApi\Models;

class SalesReceipt extends ApiObject
{
    /**
     * @var \DateTimeInterface
     */
    public $salesDateTime;

    /**
     * @var string
     */
    public $salesCustomerType;

    /**
     * @var string|null
     */
    public $salesCustomerNumber;

    /**
     * @var string|null
     */
    public $patientLicenseNumber;

    /**
     * @var string|null
     */
    public $caregiverLicenseNumber;

    /**
     * @var string
     */
    public $identificationMethod;

    /**
     * @var array
     */
    public $transactions = array();

    /**
     * @return \DateTimeInterface
     */
    public function getSalesDateTime(): \DateTimeInterface
    {
        return $this->salesDateTime;
    }

    /**
     * @param \DateTimeInterface $salesDateTime
     */
    public function setSalesDateTime(\DateTimeInterface $salesDateTime): void
    {
        $this->salesDateTime = $salesDateTime;
    }

    /**
     * @return string
     */
    public function getSalesCustomerType(): string
    {
        return $this->salesCustomerType;
    }

    /**
     * @param string $salesCustomerType
     */
    public function setSalesCustomerType(string $salesCustomerType): void
    {
        $this->salesCustomerType = $salesCustomerType;
    }

    /**
     * @return string|null
     */
    public function getSalesCustomerNumber(): ?string
    {
        return $this->salesCustomerNumber;
    }

    /**
     * @param string|null $salesCustomerNumber
     */
    public function setSalesCustomerNumber(?string $salesCustomerNumber): void
    {
        $this->salesCustomerNumber = $salesCustomerNumber;
    }

    /**
     * @return string|null
     */
    public function getPatientLicenseNumber(): ?string
    {
        return $this->patientLicenseNumber;
    }

    /**
     * @param string|null $patientLicenseNumber
     */
    public function setPatientLicenseNumber(?string $patientLicenseNumber): void
    {
        $this->patientLicenseNumber = $patientLicenseNumber;
    }

    /**
     * @return string|null
     */
    public function getCaregiverLicenseNumber(): ?string
    {
        return $this->caregiverLicenseNumber;
    }

    /**
     * @param string|null $caregiverLicenseNumber
     */
    public function setCaregiverLicenseNumber(?string $caregiverLicenseNumber): void
    {
        $this->caregiverLicenseNumber = $caregiverLicenseNumber;
    }

    /**
     * @return string
     */
    public function getIdentificationMethod(): string
    {
        return $this->identificationMethod;
    }

    /**
     * @param string $identificationMethod
     */
    public function setIdentificationMethod(string $identificationMethod): void
    {
        $this->identificationMethod = $identificationMethod;
    }

    /**
     * @return array|null
     */
    public function getTransactions(): ?array
    {
        return $this->transactions;
    }

    /**
     * @param array $transactions
     */
    public function setTransactions(array $transactions): void
    {
        $this->transactions = $transactions;
    }

    public function toArray()
    {
        return [
            'SalesDateTime' => $this->getSalesDateTime()->format(\DateTime::ISO8601),
            'SalesCustomerType' => $this->getSalesCustomerType(),
            'PatientLicenseNumber' => $this->getPatientLicenseNumber(),
            'CaregiverLicenseNumber' => $this->getCaregiverLicenseNumber(),
            'IdentificationMethod' => $this->getIdentificationMethod(),
            'Transactions' => [
                $this->getTransactions()
            ]
        ];
    }

}