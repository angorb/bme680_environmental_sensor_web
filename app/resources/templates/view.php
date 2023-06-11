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

    <title>Consciousness</title>
</head>

<body>
    <h1>Bosch Sensortec BME680</h1>

    <div class="row">
        <div class="GaugeMeter" id="iaq" data-label="IAQ" data-size="150" data-width="15" data-theme="Green-Gold-Red" data-total="500" data-showvalue="true"></div>
        <div class="GaugeMeter" id="staticIaq" data-label="Static IAQ" data-size="150" data-width="15" data-theme="Green-Gold-Red" data-total="500" data-showvalue="true"></div>
        <div class="GaugeMeter" id="gas" data-label="Gas" data-append=" Ohm" data-size="150" data-width="15" data-theme="Green-Gold-Red"></div>
    </div>

    <div class="row">
        <div class="GaugeMeter" id="temp" data-label="Temp" data-size="150" data-width="15" data-theme="Green-Gold-Red"></div>
        <div class="GaugeMeter" id="humid" data-label="Humidity" data-size="150" data-width="15" data-theme="Green-Gold-Red" data-append="%"></div>
        <div class="GaugeMeter" id="pressure" data-label="Pressure" data-size="150" data-width="15" data-theme="LightBlue-DarkBlue" data-min="650" data-total="1090" data-showvalue="true"></div>
    </div>

    <div id="co2Equiv" data-label="CO2"><span></span>ppm CO<sup>2</sup></div>
    <div id="vocEquiv" data-label="VOC"><span></span>ppm VOC</div>

    <div class="row" id="infoPanel">
        <span id="lastUpdated"></span>
        <span id="uptime"></span>
        <span id="iaqAccuracy"></span>
        <span id="statusStab"></span>
        <span id="statusRunIn"></span>
    </div>

    <div class="row">
        <div class="col-4">
            <h3>PHP Client:</h3>
            <pre><?= json_encode(json_decode($client->sensorBody), JSON_PRETTY_PRINT) ?></pre>
        </div>

        <div class="col-4">
            <h3>Ajax Client</h3>
            <pre id="ajaxresult"></pre>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="/scripts/jquery.min.js"></script>
    <script src="/scripts/bootstrap.min.js"></script>
    <script src="/scripts/consciousness.js"></script>
    <script src="/scripts/GaugeMeter.js"></script>
    <script>
        $(document).ready(function() {
            $(".GaugeMeter").gaugeMeter();

            $.get('http://192.168.1.172', function(data) {
                $('#ajaxresult').text(JSON.stringify(data, null, 2));

                console.log(data.iaq.toFixed());

                $('#iaq').gaugeMeter({
                    used: data.iaq.toFixed(),
                });

                $('#staticIaq').gaugeMeter({
                    used: data.static_iaq.toFixed()
                });

                $('#co2Equiv span').text(data.co2_equivalent.toFixed());

                $('#vocEquiv span').text(data.breath_voc_equivalent.toFixed());

                $('#temp').gaugeMeter({
                    percent: cToF(data.temperature.comp)
                });

                $('#humid').gaugeMeter({
                    percent: data.humidity.comp
                });

                $('#pressure').gaugeMeter({
                    used: 830 //(data.pressure.toFixed() / 100).toFixed()
                });

                $('#gas').gaugeMeter({
                    percent: (data.gas / 5)
                });
            }, 'json');

            function cToF(celsius) {
                return cToFahr = celsius * 9 / 5 + 32;
            }
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
