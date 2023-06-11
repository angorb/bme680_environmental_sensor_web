<?php

namespace Angorb\EnvironmentalSensor\Sensor;


class Client
{
    protected \GuzzleHttp\Client $client;
    protected string $sensorBody = '';

    public function __construct(string $ip)
    {
        $this->client = new \GuzzleHttp\Client([
            // Base URI is used with relative requests
            'base_uri' => "http://" . $ip,
        ]);

        $this->update();
    }

    public function update(): self
    {
        $res = $this->client->request('GET', '/');
        $this->sensorBody = $res->getBody();

        return $this;
    }

    public function getSensorJson(): string
    {

        return $this->sensorBody;
    }
}
