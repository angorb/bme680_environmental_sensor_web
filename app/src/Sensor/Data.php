<?php

namespace Angorb\EnvironmentalSensor\Sensor;

class Data
{
    private function __construct(
        protected float $iaq,
        protected bool $iaqCalibrated,
        protected float $staticIaq,
        protected float $co2Equivalent,
        protected float $vocEquivalent,
        protected float $rawTemperature,
        protected float $temperature,
        protected float $rawHumidity,
        protected float $humidity,
        protected float $gas,
        protected float $pressure,
        protected int $timestamp,
        protected int $uptime,
        protected bool $statusStab,
        protected bool $statusRunIn
    ) {
    }

    public static function fromJson(string $json): self
    {
        $decoded = \json_decode($json, \null, 512, \JSON_THROW_ON_ERROR);

        $data = new self(
            $decoded->iaq,
            $decoded->iaq_accuracy,
            $decoded->static_iaq,
            $decoded->co2_equivalent,
            $decoded->breath_voc_equivalent,
            $decoded->temperature->raw,
            $decoded->temperature->comp,
            $decoded->humidity->raw,
            $decoded->humidity->comp,
            $decoded->gas,
            $decoded->pressure,
            $decoded->time->now,
            $decoded->time->uptime,
            $decoded->status->stab,
            $decoded->status->run_in
        );

        return $data;
    }

    /**
     * Get the value of iaq
     */
    public function getIaq(): float
    {
        return $this->iaq;
    }

    /**
     * Get the value of iaqCalibrated
     */
    public function getIaqCalibrated(): bool
    {
        return $this->iaqCalibrated;
    }

    /**
     * Get the value of staticIaq
     */
    public function getStaticIaq(): float
    {
        return $this->staticIaq;
    }

    /**
     * Get the value of co2Equivalent
     */
    public function getCo2Equivalent(): float
    {
        return $this->co2Equivalent;
    }

    /**
     * Get the value of vocEquivalent
     */
    public function getVocEquivalent(): float
    {
        return $this->vocEquivalent;
    }

    /**
     * Get the value of rawTemperature
     */
    public function getRawTemperature(): float
    {
        return $this->rawTemperature;
    }

    /**
     * Get the value of temperature
     */
    public function getTemperature(): float
    {
        return $this->temperature;
    }

    /**
     * Get the value of rawHumidity
     */
    public function getRawHumidity(): float
    {
        return $this->rawHumidity;
    }

    /**
     * Get the value of humidity
     */
    public function getHumidity(): float
    {
        return $this->humidity;
    }

    /**
     * Get the value of gas
     */
    public function getGas(): float
    {
        return $this->gas;
    }

    /**
     * Get the value of pressure
     */
    public function getPressure(): float
    {
        return $this->pressure;
    }

    /**
     * Get the value of timestamp
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * Get the value of uptime
     */
    public function getUptime(): int
    {
        return $this->uptime;
    }

    /**
     * Get the value of statusStab
     */
    public function getStatusStab(): bool
    {
        return $this->statusStab;
    }

    /**
     * Get the value of statusRunIn
     */
    public function getStatusRunIn(): bool
    {
        return $this->statusRunIn;
    }
}
