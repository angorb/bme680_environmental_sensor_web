<?php

use Angorb\EnvironmentalSensor\Sensor\Client;

$client = new Client("192.168.1.172");
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/gauges.css">

    <title>Bosch Sensortec BME680</title>
</head>

<body>
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <h3 class="card-title">Bosch Sensortec BME680</h3>
                <div class="card-text">
                    <div class="row text-center">
                        <div class="col-sm-4 m-auto">
                            <div class="GaugeMeter" id="iaq" data-label="IAQ" data-size="150" data-width="15" data-theme="Green-Gold-Red"></div>
                        </div>
                        <div class="col-sm-4 m-auto">
                            <div class="GaugeMeter" id="staticIaq" data-label="Static IAQ" data-size="150" data-width="15" data-theme="Green-Gold-Red" data-total="500" data-showvalue="true"></div>
                        </div>
                        <div class="col-sm-4 m-auto">
                            <div class="GaugeMeter" id="gas" data-label="Gas" data-append=" Ohm" data-size="150" data-width="15" data-theme="Green-Gold-Red"></div>
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col-sm-4 m-auto">
                            <div class="GaugeMeter" id="temp" data-label="Temp" data-size="150" data-width="15" data-theme="Green-Gold-Red" data-append="&deg;F"></div>
                        </div>
                        <div class="col-sm-4 m-auto">
                            <div class="GaugeMeter" id="humid" data-label="Humidity" data-size="150" data-width="15" data-theme="Green-Gold-Red" data-append="%"></div>
                        </div>
                        <div class="col-sm-4 m-auto">
                            <div class="GaugeMeter" id="pressure" data-label="Pressure [hPa]" data-size="150" data-width="15" data-theme="LightBlue-DarkBlue" data-min="700"></div>
                        </div>
                    </div>

                    <hr>

                    <div class="row text-center">
                        <div class="col-sm-5 gasEquiv m-auto">
                            <div id="co2Equiv" data-label="CO2">
                                <h5>CO<sup>2</sup></h5>
                                <span></span> ppm
                            </div>
                        </div>
                        <div class="col-sm-5 gasEquiv m-auto">
                            <div id="vocEquiv" data-label="VOC">
                                <h5>VOC</h5>
                                <span></span> ppm
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div id="infoBar">
                        <div class="row small text-muted my-2">
                            <div class="col-auto m-auto">
                                <span id="lastUpdated"></span>
                            </div>
                        </div>

                        <div class="row small text-muted text-center" id="infoPanel">
                            <div class="col-sm-4 m-auto"><strong>Uptime:</strong> <span id="uptime"></span>
                            </div>
                            <div class="col-sm-4 m-auto"><strong>IAQ Calibrated:</strong> <span id="iaqAccuracy"></span>
                            </div>
                            <div class="col-sm-4 m-auto"><strong> Gas Stabilization:</strong> <span id="gasStab"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <button type='button' class="btn btn-secondary" id="showData">Show Raw Data</button>
                    </div>

                    <div class="row mt-2">
                        <div class="col-5 rawdata m-auto" id="phpData">
                            <h5>PHP Client:</h5>
                            <pre><?= json_encode(json_decode($client->getSensorJson()), JSON_PRETTY_PRINT) ?></pre>
                        </div>

                        <div class="col-5 rawdata m-auto" id="jsData">
                            <h5>Ajax Client</h5>
                            <pre id="ajaxresult"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row small text-muted text-center mt-2">
            <div class="col-sm-6 m-auto">&copy;<?= date('Y', time()); ?> Nick Brogna :: <a href="https://github.com/angorb/bme680_environmental_sensor_web">GitHub Repo</a></div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="/scripts/jquery.min.js"></script>
    <script src="/scripts/bootstrap.min.js"></script>
    <script src="/scripts/sensor-card.js"></script>
    <script src="/scripts/GaugeMeter.js"></script>
</body>

</html>
