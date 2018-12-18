<?php

namespace MetrcApi;

use MetrcApi\Models\Facility;
use MetrcApi\Models\Harvest;
use MetrcApi\Models\Item;
use MetrcApi\Models\ItemCategory;
use MetrcApi\Models\Package;
use MetrcApi\Models\PackageType;
use MetrcApi\Models\Plant;
use MetrcApi\Models\PlantBatch;
use MetrcApi\Models\Room;

class MetrcApi
{

    const SANDBOX_URL = 'https://sandbox-api-ca.metrc.com';
    const PRODUCTION_URL = 'https://api-ca.metrc.com';

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $licenseNumber;

    /**
     * @var bool|null
     */
    private $sandbox;

    /**
     * @var string
     */
    private $method = 'GET';

    /**
     * @var string
     */
    private $route = null;

    /**
     * MetrcApi constructor.
     * @param string $username
     * @param string $password
     * @param string $licenseNumber
     * @param bool|null $sandbox
     */
    public function __construct($username, $password, $licenseNumber, $sandbox = false)
    {
        $this->username      = $username;
        $this->password      = $password;
        $this->licenseNumber = $licenseNumber;
        $this->sandbox       = $sandbox;
    }

    /**
     * @return MetrcApiResponse
     * @throws \Exception
     */
    public function executeAction(): MetrcApiResponse
    {
        $base = $this->sandbox ? self::SANDBOX_URL : self::PRODUCTION_URL;

        $ch = curl_init($base.$this->route.$this->licenseNumber);
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => [
                $this->getAuthenticationHeader(),
                'Content-Type: application/json'
            ],
            CURLOPT_RETURNTRANSFER => 1
        ]);

        if($this->method != 'GET') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($this->method));
        }

        $result = curl_exec($ch);

        $response = new MetrcApiResponse();
        $response->setRawResponse($result);
        $response->setHttpCode(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        return $response;
    }

    private function getAuthenticationHeader()
    {
        return sprintf("Authorization: Basic %s", base64_encode($this->username.":".$this->password));
    }

    private function mapResponseToObject(MetrcApiResponse $response, $class)
    {
        $obj = new $class;

        foreach($response->getResponse() as $k => $v) {
            $method = sprintf('set%s', ucwords($k));
            $obj->{$method}($v);
        }

        return $obj;
    }

    private function mapResponseToObjectArray(MetrcApiResponse $response, $class)
    {
        $arr = [];

        foreach($response->getResponse() as $k => $v) {
            $arr[$k] = new $class;
            foreach($response[$k] as $k2 => $v2) {
                $method = sprintf('set%s', ucwords($k));
                $arr[$k]->{$method}($v);
            }
        }

        return $arr;
    }

    /**
     * @return array|null
     * @throws \Exception
     */
    public function getFacilities(): ?array
    {
        $this->route = '/facilities/v1/';
        $response = $this->executeAction();
        return $this->mapResponseToObject($response, Facility::class);
    }

    /**
     * @param string $type type filter (active|onhold|inactive)
     * @return array|null
     * @throws \Exception
     */
    public function getHarvests($type = 'active'): ?array
    {
        $this->route = '/harvests/v1/' . $type;
        $response = $this->executeAction();
        return $this->mapResponseToObject($response, Harvest::class);
    }

    /**
     * @param string $id
     * @return array|null
     * @throws \Exception
     */
    public function getItem($id): ?Item
    {
        $this->route = '/items/v1/' . $id;
        $response = $this->executeAction();
        return $this->mapResponseToObject($response, Item::class);
    }

    /**
     * @param string $type type filter (active|onhold|inactive)
     * @return array|null
     * @throws \Exception
     */
    public function getItems($type = 'active'): ?array
    {
        $this->route = '/items/v1/' . $type;
        $response = $this->executeAction();
        return $this->mapResponseToObject($response, Item::class);
    }

    /**
     * @return array|null
     * @throws \Exception
     */
    public function getItemCategories(): ?array
    {
        $this->route = '/items/v1/categories';
        $response = $this->executeAction();
        return $this->mapResponseToObject($response, ItemCategory::class);
    }

    /**
     * @param $id
     * @return Package|null
     * @throws \Exception
     */
    public function getPackage($id): ?Package
    {
        $this->route = '/packages/v1/' . $id;
        $response = $this->executeAction();
        return $this->mapResponseToObject($response, Package::class);
    }

    /**
     * @param string $type type filter (active|onhold|inactive)
     * @return array
     * @throws \Exception
     */
    public function getPackages($type = 'active'): ?array
    {
        $this->route = '/packages/v1/' . $type;
        $response = $this->executeAction();
        return $this->mapResponseToObjectArray($response, Package::class);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getPackageTypes(): ?array
    {
        $this->route = '/packages/v1/types';
        $response = $this->executeAction();
        return $this->mapResponseToObjectArray($response, PackageType::class);
    }

    /**
     * @param int|null $id
     * @return PlantBatch|null
     * @throws \Exception
     */
    public function getPlantBatch($id): ?PlantBatch
    {
        $this->route = '/plantbatches/v1/' . $id;
        $response = $this->executeAction();
        return $this->mapResponseToObject($response, PlantBatch::class);
    }

    /**
     * @param string $type type filter (active|inactive)
     * @return array
     * @throws \Exception
     */
    public function getPlantBatches($type = 'active'): ?array
    {
        $this->route = '/plantbatches/v1/' . $type;
        $response = $this->executeAction();
        return $this->mapResponseToObjectArray($response, PlantBatch::class);
    }

    /**
     * @param int|null $id
     * @return Room|null
     * @throws \Exception
     */
    public function getPlant(?int $id): ?Plant
    {
        $this->route = '/plants/v1/' . $id;
        $response = $this->executeAction();
        return $this->mapResponseToObject($response, Plant::class);
    }

    /**
     * @param string $type type filter (vegetative|flowering|onhold|inactive)
     * @return array
     * @throws \Exception
     */
    public function getPlants($type = 'active'): ?array
    {
        $this->route = '/plants/v1/' . $type;
        $response = $this->executeAction();
        return $this->mapResponseToObjectArray($response, Plant::class);
    }

    /**
     * @param int|null $id
     * @return Room|null
     * @throws \Exception
     */
    public function getRoom(?int $id): ?Room
    {
        $this->route = '/rooms/v1/' . $id;
        $response = $this->executeAction();
        return $this->mapResponseToObject($response, Room::class);
    }

    /**
     * @param string $type type filter (active|onhold|inactive)
     * @return array
     * @throws \Exception
     */
    public function getRooms($type = 'active'): ?array
    {
        $this->route = '/rooms/v1/' . $type;
        $response = $this->executeAction();
        return $this->mapResponseToObjectArray($response, Room::class);
    }

    /**
     * @param int|null $id
     * @return bool
     * @throws \Exception
     */
    public function deleteRoom(?int $id): bool
    {
        $this->route = '/rooms/v1/' . $id;
        $this->method = 'DELETE';
        $response = $this->executeAction();
        return $response->getSuccess();
    }

}