<?php

use Angorb\EnvironmentalSensor\SensorClient;

$client = new SensorClient("192.168.1.172");
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/main.css">

    <title>Bosch Sensortec BME680</title>
</head>

<body>
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <h3 class="card-title">Bosch Sensortec BME680</h3>
                <div class="card-text text-center">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="GaugeMeter" id="iaq" data-label="IAQ" data-size="150" data-width="15" data-theme="Green-Gold-Red"></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="GaugeMeter" id="staticIaq" data-label="Static IAQ" data-size="150" data-width="15" data-theme="Green-Gold-Red" data-total="500" data-showvalue="true"></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="GaugeMeter" id="gas" data-label="Gas" data-append=" Ohm" data-size="150" data-width="15" data-theme="Green-Gold-Red"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="GaugeMeter" id="temp" data-label="Temp" data-size="150" data-width="15" data-theme="Green-Gold-Red"></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="GaugeMeter" id="humid" data-label="Humidity" data-size="150" data-width="15" data-theme="Green-Gold-Red" data-append="%"></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="GaugeMeter" id="pressure" data-animationstep='0' data-label="Pressure" data-size="150" data-width="15" data-theme="LightBlue-DarkBlue" data-min="650" data-total="1090" data-showvalue="true"></div>
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col-sm-6 gasEquiv">
                            <div id="co2Equiv" data-label="CO2">
                                <h5>CO<sup>2</sup></h5>
                                <span></span> ppm
                            </div>
                        </div>
                        <div class="col-sm-6 gasEquiv">
                            <div id="vocEquiv" data-label="VOC">
                                <h5>VOC</h5>
                                <span></span> ppm
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row small text-muted text-center mb-2" id="infoPanel">
                        <div class="col-sm-2">Last Updated: <span id="lastUpdated"></span>
                        </div>
                        <div class="col-sm-2">Uptime: <span id="uptime"></span> sec
                        </div>
                        <div class="col-sm-2">IAQ Calibrated: <span id="iaqAccuracy"></span>
                        </div>
                        <div class="col-sm-2">Status[Stab]: <span id="statusStab"></span>
                        </div>
                        <div class="col-sm-2">Status[RunIn]: <span id="statusRunIn"></span>
                        </div>
                    </div>

                    <div class="row">
                        <button type='button' class="btn btn-secondary" id="showData">Show Raw Data</button>
                        <div class="col-5 rawdata" id="phpData">
                            <h3>PHP Client:</h3>
                            <pre><?= json_encode(json_decode($client->sensorBody), JSON_PRETTY_PRINT) ?></pre>
                        </div>

                        <div class="col-5 rawdata" id="jsData">
                            <h3>Ajax Client</h3>
                            <pre id="ajaxresult"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="/scripts/jquery.min.js"></script>
    <script src="/scripts/bootstrap.min.js"></script>
    <script src="/scripts/consciousness.js"></script>
    <script src="/scripts/GaugeMeter.js"></script>
    <script>
        function updateSensorData() {
            $.get('http://192.168.1.172', function(data) {
                $('#ajaxresult').text(JSON.stringify(data, null, 2));

                console.log(data.iaq.toFixed());

                $('#iaq').gaugeMeter({
                    used: Math.round(data.iaq),
                    showvalue: true,
                    min: 0,
                    total: 500,
                    animationstep: 0
                });

                $('#staticIaq').gaugeMeter({
                    used: Math.round(data.static_iaq),
                    animationstep: 0
                });

                $('#co2Equiv span').text(parseInt(data.co2_equivalent));

                $('#vocEquiv span').text(data.breath_voc_equivalent.toFixed());

                $('#temp').gaugeMeter({
                    percent: cToF(data.temperature.comp),
                    animationstep: 0
                });

                $('#humid').gaugeMeter({
                    percent: data.humidity.comp,
                    animationstep: 0
                });

                $('#pressure').gaugeMeter({
                    used: 830 //(data.pressure.toFixed() / 100).toFixed()
                });

                $('#gas').gaugeMeter({
                    percent: data.gas,
                    animationstep: 0
                });

                $('#lastUpdated').text(data.time.now);
                $('#uptime').text(data.time.uptime);
            }, 'json');
            setTimeout(updateSensorData, 5000);
        }

        function cToF(celsius) {
            return cToFahr = celsius * 9 / 5 + 32;
        }

        function toggleRawData() {
            console.log('test');
            if ($('.rawdata').is(':visible')) {
                console.log('visible');
                $('.rawdata').hide();
                return;
            }

            $('.rawdata').show();
        }

        $(document).ready(function() {
            $(".GaugeMeter").gaugeMeter();
            $('.rawdata').hide();
            updateSensorData();

            $('#showData').on('click', toggleRawData);
        });
    </script>
    <style>
        pre {
            width: 40%;
            display: inline;
        }

        .GaugeMeter {
            Position: Relative;
            Text-Align: Center;
            Overflow: Hidden;
            Cursor: Default;
            display: inline;
        }

        .GaugeMeter SPAN,
        .GaugeMeter B {
            Margin: 0 23%;
            Width: 54%;
            Position: Absolute;
            Text-align: Center;
            Display: Inline-Block;
            Color: RGBa(0, 0, 0, .8);
            Font-Weight: 100;
            Font-Family: "Open Sans", Arial;
            Overflow: Hidden;
            White-Space: NoWrap;
            Text-Overflow: Ellipsis;
        }

        .GaugeMeter[data-style="Semi"] B {
            Margin: 0 10%;
            Width: 80%;
        }

        .GaugeMeter S,
        .GaugeMeter U {
            Text-Decoration: None;
            Font-Size: .5em;
            Opacity: .5;
        }

        .GaugeMeter B {
            Color: Black;
            Font-Weight: 300;
            Font-Size: .5em;
            Opacity: .8;
        }
    </style>
</body>

</html>