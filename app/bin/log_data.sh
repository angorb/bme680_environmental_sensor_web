#!/bin/env php
<?php

use Angorb\EnvironmentalSensor\Database;
use Angorb\EnvironmentalSensor\Sensor\Client;
use Angorb\EnvironmentalSensor\Sensor\Data;

require_once __DIR__ . '/../vendor/autoload.php';


$client = new Client('192.168.1.172');
$datbase = new Database('localhost', 'development', 'user', 'password');

$recordsLogged = 0;

while (true) {
    $dateString = date_format(date_create('now'), 'Y-m-d H:i:s a');

    try {
        $json = $client->update()->getSensorJson();
        $data = Data::fromJson($json);
        $datbase->insertLog($data);

        echo '[' . $dateString . ']: logged record ' . (++$recordsLogged) . PHP_EOL;
    } catch (\Throwable $t) {
        echo '[' . $dateString . ']: ' . $t->getMessage();
    }

    sleep(30);
}
