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
use MetrcApi\Models\Strain;

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
     * @param bool $obj
     * @return MetrcApiResponse
     * @throws Exception\InvalidMetrcResponseException
     */
    private function executeAction($obj = false): MetrcApiResponse
    {
        $base = $this->sandbox ? self::SANDBOX_URL : self::PRODUCTION_URL;

        $ch = curl_init($base.$this->route.'?licenseNumber='.$this->licenseNumber);
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => [
                $this->getAuthenticationHeader(),
                'Content-Type: application/json'
            ],
            CURLOPT_RETURNTRANSFER => 1
        ]);

        if($this->method != 'GET') {
            if($this->method == 'POST') {
                curl_setopt($ch, CURLOPT_POST, true);
                if($obj) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([$obj->toArray()]));
                }
            } else {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($this->method));
            }
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

        $responseArray = $response->getResponse();

        foreach($responseArray as $k => $v) {
            $arr[$k] = new $class;
            foreach($responseArray[$k] as $k2 => $v2) {
                $method = sprintf('set%s', ucwords($k2));
                $arr[$k]->{$method}($v2);
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
        return $this->mapResponseToObjectArray($response, Facility::class);
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
        return $this->mapResponseToObjectArray($response, Harvest::class);
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
        return $this->mapResponseToObjectArray($response, Item::class);
    }

    /**
     * @param Item $item
     * @return MetrcApiResponse
     * @throws \Exception
     */
    public function createItem(Item $item): MetrcApiResponse
    {
        $this->route = '/items/v1/create';
        $this->method = 'POST';
        $response = $this->executeAction($item);
        return $response;
    }

    /**
     * @param Item $item
     * @return MetrcApiResponse
     * @throws \Exception
     */
    public function updateItem(Item $item): MetrcApiResponse
    {
        $this->route = '/items/v1/update';
        $this->method = 'POST';
        $response = $this->executeAction($item);
        return $response;
    }

    /**
     * @return array|null
     * @throws \Exception
     */
    public function getItemCategories(): ?array
    {
        $this->route = '/items/v1/categories';
        $response = $this->executeAction();
        return $this->mapResponseToObjectArray($response, ItemCategory::class);
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
     * @param Room $room
     * @return MetrcApiResponse
     * @throws \Exception
     */
    public function createRoom(Room $room): MetrcApiResponse
    {
        $this->route = '/rooms/v1/create';
        $this->method = 'POST';
        $response = $this->executeAction($room);
        return $response;
    }

    /**
     * @param Room $room
     * @return MetrcApiResponse
     * @throws \Exception
     */
    public function updateRoom(Room $room): MetrcApiResponse
    {
        $this->route = '/rooms/v1/update';
        $this->method = 'POST';
        $response = $this->executeAction($room);
        return $response;
    }

    /**
     * @param int|null $id
     * @return MetrcApiResponse
     * @throws \Exception
     */
    public function deleteRoom(?int $id): MetrcApiResponse
    {
        $this->route = '/rooms/v1/' . $id;
        $this->method = 'DELETE';
        $response = $this->executeAction();
        return $response;
    }

    /**
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function getStrain($id): ?array
    {
        $this->route = '/strains/v1/' . $id;
        $response = $this->executeAction();
        return $this->mapResponseToObject($response, Strain::class);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getStrains(): ?array
    {
        $this->route = '/strains/v1/active';
        $response = $this->executeAction();
        return $this->mapResponseToObjectArray($response, Strain::class);
    }

    /**
     * @param train $strain
     * @return MetrcApiResponse
     * @throws \Exception
     */
    public function createStrain(train $strain): MetrcApiResponse
    {
        $this->route = '/strains/v1/create';
        $this->method = 'POST';
        $response = $this->executeAction($strain);
        return $response;
    }

    /**
     * @param strain $strain
     * @return MetrcApiResponse
     * @throws \Exception
     */
    public function updateStrain(Strain $strain): MetrcApiResponse
    {
        $this->route = '/strains/v1/update';
        $this->method = 'POST';
        $response = $this->executeAction($strain);
        return $response;
    }

    /**
     * @param int|null $id
     * @return MetrcApiResponse
     * @throws \Exception
     */
    public function deleteStrain(?int $id): MetrcApiResponse
    {
        $this->route = '/strains/v1/' . $id;
        $this->method = 'DELETE';
        $response = $this->executeAction();
        return $response;
    }

}