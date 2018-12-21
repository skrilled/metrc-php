<?php

namespace MetrcApi;

use MetrcApi\Exception\AccessDeniedException;
use MetrcApi\Exception\InvalidMetrcResponseException;
use MetrcApi\Models\ApiObject;
use MetrcApi\Models\Facility;
use MetrcApi\Models\Harvest;
use MetrcApi\Models\HarvestPackage;
use MetrcApi\Models\HarvestWaste;
use MetrcApi\Models\Item;
use MetrcApi\Models\ItemCategory;
use MetrcApi\Models\LabTest;
use MetrcApi\Models\Package;
use MetrcApi\Models\PackageFinish;
use MetrcApi\Models\Plant;
use MetrcApi\Models\PlantBatch;
use MetrcApi\Models\PlantBatchDestruction;
use MetrcApi\Models\PlantBatchPlanting;
use MetrcApi\Models\PlantBatchPlantingGrowthPhase;
use MetrcApi\Models\PlantHarvest;
use MetrcApi\Models\Room;
use MetrcApi\Models\SalesReceipt;
use MetrcApi\Models\Strain;
use MetrcApi\Models\Transfer;

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

    private $queryParams;

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
        $this->queryParams   = [
            'licenseNumber' => $this->licenseNumber
        ];
    }

    /**
     * @param bool|ApiObject $obj
     * @return MetrcApiResponse
     * @throws \Exception|InvalidMetrcResponseException
     */
    private function executeAction($obj = false): MetrcApiResponse
    {
        $base = $this->sandbox ? self::SANDBOX_URL : self::PRODUCTION_URL;

        $ch = curl_init($base.$this->route.'?'.http_build_query($this->queryParams));
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
            } else {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($this->method));
            }
            if($obj) {
                if(is_iterable($obj)) {
                    $objects = [];
                    /** @var ApiObject $o */
                    foreach($obj as $o) {
                        $objects[] = $o;
                    }
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                        $objects
                    ]));

                } else {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([$obj->toArray()]));
                }
            }
        }

        $result = curl_exec($ch);

        $response = new MetrcApiResponse();
        $response->setRawResponse($result);
        $response->setHttpCode(curl_getinfo($ch, CURLINFO_HTTP_CODE));

        if($response->getHttpCode() == 401) {
            throw new AccessDeniedException();
        } elseif($response->getHttpCode() == 500) {
            throw new InvalidMetrcResponseException(isset($response->getResponse()['Message']) ? $response->getResponse()['Message'] : 'API Response Returned 500 error!');
        }

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
     * @throws \Exception|InvalidMetrcResponseException
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
     * @throws \Exception|InvalidMetrcResponseException
     */
    public function getHarvests($type = 'active'): ?array
    {
        $this->route = '/harvests/v1/' . $type;
        $response = $this->executeAction();
        return $this->mapResponseToObjectArray($response, Harvest::class);
    }

    /**
     * @param HarvestPackage $package
     * @return MetrcApiResponse
     * @throws InvalidMetrcResponseException
     */
    public function createHarvestPackage(HarvestPackage $package): MetrcApiResponse
    {
        $this->route = '/harvests/v1/createpackages';
        $this->method = 'POST';
        $response = $this->executeAction($package);
        return $response;
    }

    /**
     * @param HarvestWaste $waste
     * @return MetrcApiResponse
     * @throws InvalidMetrcResponseException
     */
    public function createHarvestWaste(HarvestWaste $waste): MetrcApiResponse
    {
        $this->route = '/harvests/v1/removewaste';
        $this->method = 'POST';
        $response = $this->executeAction($waste);
        return $response;
    }

    /**
     * @param Harvest $harvest
     * @return MetrcApiResponse
     * @throws InvalidMetrcResponseException
     */
    public function finishHarvest(Harvest $harvest): MetrcApiResponse
    {
        $this->route = '/harvests/v1/finish';
        $this->method = 'POST';
        $response = $this->executeAction($harvest);
        return $response;
    }

    /**
     * @param Harvest $harvest
     * @return MetrcApiResponse
     * @throws InvalidMetrcResponseException
     */
    public function unfinishHarvest(Harvest $harvest): MetrcApiResponse
    {
        $this->route = '/harvests/v1/unfinish';
        $this->method = 'POST';
        $response = $this->executeAction($harvest);
        return $response;
    }

    /**
     * @param string $id
     * @return array|null
     * @throws \Exception|InvalidMetrcResponseException
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
     * @throws \Exception|InvalidMetrcResponseException
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
     * @throws \Exception|InvalidMetrcResponseException
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
     * @throws \Exception|InvalidMetrcResponseException
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
     * @throws \Exception|InvalidMetrcResponseException
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
     * @throws \Exception|InvalidMetrcResponseException
     */
    public function getPackage($id): ?Package
    {
        $this->route = '/packages/v1/' . $id;
        $response = $this->executeAction();
        return $this->mapResponseToObject($response, Package::class);
    }

    /**
     * @param PackageFinish $package
     * @return MetrcApiResponse
     * @throws \Exception|InvalidMetrcResponseException
     */
    public function finishPackage(PackageFinish $package): MetrcApiResponse
    {
        $this->route = '/packages/v1/finish';
        $response = $this->executeAction($package);
        return $response;
    }

    /**
     * @param PackageFinish $package
     * @return MetrcApiResponse
     * @throws \Exception|InvalidMetrcResponseException
     */
    public function unfinishPackage(PackageFinish $package): MetrcApiResponse
    {
        $this->route = '/packages/v1/unfinish';
        $response = $this->executeAction($package);
        return $response;
    }

    /**
     * @param string $type type filter (active|onhold|inactive)
     * @return array
     * @throws \Exception|InvalidMetrcResponseException
     */
    public function getPackages($type = 'active'): ?array
    {
        $this->route = '/packages/v1/' . $type;
        $response = $this->executeAction();
        return $this->mapResponseToObjectArray($response, Package::class);
    }

    /**
     * @param Package $package
     * @return MetrcApiResponse
     * @throws \Exception|InvalidMetrcResponseException
     */
    public function createPackage(Package $package): MetrcApiResponse
    {
        $this->route = '/packages/v1/create';
        $this->method = 'POST';
        $response = $this->executeAction($package);
        return $response;
    }

    /**
     * @return array
     * @throws \Exception|InvalidMetrcResponseException
     */
    public function getPackageTypes(): ?array
    {
        $this->route = '/packages/v1/types';
        $response = $this->executeAction();
        return $response->getResponse();
    }

    /**
     * @param int|null $id
     * @return PlantBatch|null
     * @throws \Exception|InvalidMetrcResponseException
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
     * @throws \Exception|InvalidMetrcResponseException
     */
    public function getPlantBatches($type = 'active'): ?array
    {
        $this->route = '/plantbatches/v1/' . $type;
        $response = $this->executeAction();
        return $this->mapResponseToObjectArray($response, PlantBatch::class);
    }

    /**
     * @param PlantBatchPlanting $planting
     * @return MetrcApiResponse
     * @throws \Exception|InvalidMetrcResponseException
     */
    public function createPlanting(PlantBatchPlanting $planting): MetrcApiResponse
    {
        $this->route = '/plantbatches/v1/createplantings';
        $this->method = 'POST';
        $response = $this->executeAction($planting);
        return $response;
    }

    /**
     * @param array $plantings
     * @return MetrcApiResponse
     * @throws \Exception|InvalidMetrcResponseException
     */
    public function createPlantings(array $plantings): MetrcApiResponse
    {
        $this->route = '/plantbatches/v1/createplantings';
        $this->method = 'POST';
        $response = $this->executeAction(
            $plantings
        );
        return $response;
    }

    /**
     * @param PlantBatchPlantingGrowthPhase $planting
     * @return MetrcApiResponse
     * @throws \Exception|InvalidMetrcResponseException
     */
    public function changeGrowthPhase(PlantBatchPlantingGrowthPhase $planting): MetrcApiResponse
    {
        $this->route = '/plantbatches/v1/changegrowthphase';
        $this->method = 'POST';
        $response = $this->executeAction($planting);
        return $response;
    }

    /**
     * @param PlantBatchDestruction $batchDestruction
     * @return MetrcApiResponse
     * @throws \Exception|InvalidMetrcResponseException
     */
    public function destroyPlantBatch(PlantBatchDestruction $batchDestruction): MetrcApiResponse
    {
        $this->route = '/plantbatches/v1/destroy';
        $this->method = 'POST';
        $response = $this->executeAction($batchDestruction);
        return $response;
    }

    /**
     * @param int|null $id
     * @return Room|null
     * @throws \Exception|InvalidMetrcResponseException
     */
    public function getPlant(?int $id): ?Plant
    {
        $this->route = '/plants/v1/' . $id;
        $response = $this->executeAction();
        return $this->mapResponseToObject($response, Plant::class);
    }

    /**
     * @param string $type type filter (vegetative|flowering|onhold|inactive)
     * @param \DateTimeInterface|null $startDate
     * @param \DateTimeInterface|null $stopDate
     * @return array
     * @throws InvalidMetrcResponseException
     */
    public function getPlants($type = 'vegetative', \DateTimeInterface $startDate = null, \DateTimeInterface $stopDate = null): ?array
    {
        $this->route = '/plants/v1/' . $type;
        if($startDate && $stopDate) {
            $this->queryParams['lastModifiedStart'] = $startDate->format(\DateTime::ISO8601);
            $this->queryParams['lastModifiedEnd']   = $stopDate->format(\DateTime::ISO8601);
        }
        $response = $this->executeAction();
        return $this->mapResponseToObjectArray($response, Plant::class);
    }

    /**
     * @return array|null
     * @throws \Exception|InvalidMetrcResponseException
     */
    public function getPlantWasteReasons(): ?array
    {
        $this->route = '/plants/v1/waste/reasons';
        $response = $this->executeAction();
        return $response->getResponse();
    }

    /**
     * @param Plant $plant
     * @return MetrcApiResponse
     * @throws InvalidMetrcResponseException
     */
    public function destroyPlant(Plant $plant): MetrcApiResponse
    {
        $this->route = '/plants/v1/destroyplants';
        $this->method = 'POST';
        $response = $this->executeAction($plant);
        return $response;
    }

    /**
     * @param Plant $plant
     * @return MetrcApiResponse
     * @throws InvalidMetrcResponseException
     */
    public function movePlant(Plant $plant): MetrcApiResponse
    {
        $this->route = '/plants/v1/moveplants';
        $this->method = 'POST';
        $response = $this->executeAction($plant);
        return $response;
    }

    /**
     * @param PlantHarvest $plant
     * @return MetrcApiResponse
     * @throws InvalidMetrcResponseException
     */
    public function manicurePlant(PlantHarvest $plant): MetrcApiResponse
    {
        $this->route = '/plants/v1/manicureplants';
        $this->method = 'POST';
        $response = $this->executeAction($plant);
        return $response;
    }

    /**
     * @param PlantHarvest $plant
     * @return MetrcApiResponse
     * @throws InvalidMetrcResponseException
     */
    public function harvestPlant(PlantHarvest $plant): MetrcApiResponse
    {
        $this->route = '/plants/v1/harvestplants';
        $this->method = 'POST';
        $response = $this->executeAction($plant);
        return $response;
    }

    /**
     * @param int|null $id
     * @return Room|null
     * @throws \Exception|InvalidMetrcResponseException
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
     * @throws \Exception|InvalidMetrcResponseException
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
     * @throws \Exception|InvalidMetrcResponseException
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
     * @throws \Exception|InvalidMetrcResponseException
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
     * @throws \Exception|InvalidMetrcResponseException
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
     * @throws \Exception|InvalidMetrcResponseException
     */
    public function getStrain($id): ?array
    {
        $this->route = '/strains/v1/' . $id;
        $response = $this->executeAction();
        return $this->mapResponseToObject($response, Strain::class);
    }

    /**
     * @return array
     * @throws \Exception|InvalidMetrcResponseException
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
     * @throws \Exception|InvalidMetrcResponseException
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
     * @throws \Exception|InvalidMetrcResponseException
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
     * @throws \Exception|InvalidMetrcResponseException
     */
    public function deleteStrain(?int $id): MetrcApiResponse
    {
        $this->route = '/strains/v1/' . $id;
        $this->method = 'DELETE';
        $response = $this->executeAction();
        return $response;
    }

    /**
     * @param $id
     * @return array
     * @throws InvalidMetrcResponseException
     */
    public function getSalesReceipt($id): ?array
    {
        $this->route = '/sales/v1/receipts/' . $id;
        $response = $this->executeAction();
        return $this->mapResponseToObject($response, SalesReceipt::class);
    }

    /**
     * @param \DateTimeInterface $startDate
     * @param \DateTimeInterface $stopDate
     * @return array
     * @throws InvalidMetrcResponseException
     */
    public function getSalesReceipts(\DateTimeInterface $startDate, \DateTimeInterface $stopDate): ?array
    {
        $this->route = '/sales/v1/receipts';
        $this->queryParams['lastModifiedStart'] = $startDate->format(\DateTime::ISO8601);
        $this->queryParams['lastModifiedEnd']   = $stopDate->format(\DateTime::ISO8601);
        $response = $this->executeAction();
        return $this->mapResponseToObjectArray($response, SalesReceipt::class);
    }

    /**
     * @param SalesReceipt $receipt
     * @return MetrcApiResponse
     * @throws \Exception|InvalidMetrcResponseException
     */
    public function createSalesReceipt(SalesReceipt $receipt): MetrcApiResponse
    {
        $this->route = '/sales/v1/receipts';
        $this->method = 'POST';
        $response = $this->executeAction($receipt);
        return $response;
    }

    /**
    /**
     * @param SalesReceipt $receipt
     * @return MetrcApiResponse
     * @throws \Exception|InvalidMetrcResponseException
     */
    public function updateSalesReceipt(SalesReceipt $receipt): MetrcApiResponse
    {
        $this->route = '/sales/v1/receipts';
        $this->method = 'PUT';
        $response = $this->executeAction($receipt);
        return $response;
    }

    /**
     * @param $id
     * @return MetrcApiResponse
     * @throws \Exception|InvalidMetrcResponseException
     */
    public function deleteSalesReceipt($id): MetrcApiResponse
    {
        $this->route = '/sales/v1/receipts/' . $id;
        $this->method = 'DELETE';
        $response = $this->executeAction();
        return $response;
    }

    /**
     * @return array|null
     * @throws \Exception|InvalidMetrcResponseException
     */
    public function getLabTestTypes(): ?array
    {
        $this->route = '/labtests/v1/types';
        $response = $this->executeAction();
        return $response->getResponse();
    }

    /**
     * @param LabTest $labTest
     * @return MetrcApiResponse
     * @throws \Exception|InvalidMetrcResponseException
     */
    public function createLabTest(LabTest $labTest): MetrcApiResponse
    {
        $this->route = '/labtests/v1/record';
        $this->method = 'POST';
        $response = $this->executeAction($labTest);
        return $response;
    }

    /**
     * @param string $type
     * @param \DateTimeInterface $startDate
     * @param \DateTimeInterface $stopDate
     * @return array
     * @throws InvalidMetrcResponseException
     */
    public function getTransfers($type = 'incoming', \DateTimeInterface $startDate = null, \DateTimeInterface $stopDate = null): ?array
    {
        $this->route = '/transfers/v1/' . $type;
        if($startDate && $stopDate) {
            $this->queryParams['lastModifiedStart'] = $startDate->format(\DateTime::ISO8601);
            $this->queryParams['lastModifiedEnd'] = $stopDate->format(\DateTime::ISO8601);
        }
        $response = $this->executeAction();
        return $this->mapResponseToObjectArray($response, Transfer::class);
    }

}