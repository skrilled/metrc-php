<?php

require_once __DIR__ .'/vendor/autoload.php';

$api = new \MetrcApi\MetrcApi(
    'FusVbe4Yv6W1DGNuxKNhByXU6RO6jSUPcbRCoRDD98VNXc4D',
    'cbzfcdmDlhtecC3vaRYTWAr8-naRsPQMu09dHm6-IscGVDHY',
    'CAL17-0000005'
);

var_dump($api->getRooms());