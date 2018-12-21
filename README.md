# metrc-sdk

PHP SDK/API for working with metrc (https://metrc.com). 

### Installation
This library is written for php 7.1 or better, and uses the ext-curl, and ext-json libraries

#### Using Composer
```
composer require alternatehealth/metrc
```

### Example Usage
#### Fetching a List of Facilities
```php
<?php

// 3rd and 4th optional parameters are $sandbox (bool) and $state (string, defaults to 'ca' for california)
$api = new \MetrcApi\MetrcApi('username', 'password', 'licenseNumber');

$facilities = $api->getFacilities();

var_dump($facilities);
```

#### Creating a Room
```php
<?php

$api = new \MetrcApi\MetrcApi('username', 'password', 'licenseNumber');

$room = new \MetrcApi\Models\Room;
$room->setName("Room Name");
$response = $api->createRoom($room);

var_dump($response);
```
