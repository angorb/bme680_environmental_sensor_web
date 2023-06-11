<?php

namespace Angorb\EnvironmentalSensor;

use Angorb\EnvironmentalSensor\Sensor\Data;
use Monolog\LogRecord;
use PDO;

class Database
{
    private \PDO $dbh;

    public function __construct(string $host, string $db, string $username, string $password, int $port = 5432)
    {
        $dsn = $this->getDsn($host, $db, $username, $password, $port);
        $this->dbh = new PDO($dsn);
    }

    protected function getDsn(string $host, string $db, string $username, string $password, int $port = 5432): string
    {
        // FIXME insecure
        return "pgsql:host={$host};port={$port};dbname={$db};user={$username};password={$password}";
    }

    public function insertLog(Data $data)
    {
        $sql = 'insert into
        bme680_sensor_data (
            "time",
            iaq,
            iaq_accuracy,
            static_iaq,
            co2_equivalent,
            breath_voc_equivalent,
            temperature_raw,
            temperature_comp,
            pressure,
            humidity_raw,
            humidity_comp,
            gas,
            status_stab,
            status_run_in,
            uptime
        ) values (
            :time,
            :iaq,
            :iaq_accuracy,
            :static_iaq,
            :co2_equivalent,
            :breath_voc_equivalent,
            :temperature_raw,
            :temperature_comp,
            :pressure,
            :humidity_raw,
            :humidity_comp,
            :gas,
            :status_stab,
            :status_run_in,
            :uptime
        )';

        $sth = $this->dbh->prepare($sql);
        $sth->execute([
            ':time' => $data->getTimestamp(),
            ':iaq' => $data->getIaq(),
            ':iaq_accuracy' => $data->getIaqCalibrated(),
            ':static_iaq' => $data->getStaticIaq(),
            ':co2_equivalent' => $data->getCo2Equivalent(),
            ':breath_voc_equivalent' => $data->getVocEquivalent(),
            ':temperature_raw' => $data->getRawTemperature(),
            ':temperature_comp' => $data->getTemperature(),
            ':pressure' => $data->getPressure(),
            ':humidity_raw' => $data->getRawHumidity(),
            ':humidity_comp' => $data->getHumidity(),
            ':gas' => $data->getGas(),
            ':status_stab' => $data->getStatusStab(),
            ':status_run_in' => $data->getStatusRunIn(),
            ':uptime' => $data->getUptime()
        ]);
    }
}
