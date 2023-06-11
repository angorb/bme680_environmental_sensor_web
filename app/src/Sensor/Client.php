<?php

namespace Angorb\EnvironmentalSensor\Sensor;

class Client
{
    protected \GuzzleHttp\Client $client;
    protected string $sensorBody = '';

    public function __construct(string $ip)
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => "http://" . $ip,
        ]);

        $this->update();
    }

    public function update(?string $path = null): self
    {
        $uri = '/' . $path;
        $response = $this->client->request('GET', $uri);
        $this->sensorBody = $response->getBody();

        return $this;
    }

    public function getSensorJson(): string
    {

        return $this->sensorBody;
    }
}
