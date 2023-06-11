<?php

namespace Angorb\EnvironmentalSensor;

use GuzzleHttp\Client;

class SensorClient
{
    public string $sensorBody = '';

    public function __construct(string $ip)
    {
        $client = new Client();
        $res = $client->request('GET', $ip);
        //echo $res->getStatusCode();
        // "200"
        //echo $res->getHeader('content-type')[0];
        // 'application/json; charset=utf8'
        $this->sensorBody = $res->getBody();
    }
}
