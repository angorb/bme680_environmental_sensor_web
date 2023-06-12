# bme680_environmental_sensor_web

A simple asynchronous HTTP web client and server for the SparkFun Bosch Sensortec BME680 Qwiic Breakout and ESP32 Thing Plus C. This work is wholly my own goofy weekend project and is not sanctioned by or affiliated with my employer in any way.

![image](https://github.com/angorb/bme680_environmental_sensor_web/assets/17731071/70288ee5-c8e7-49d8-9e54-d0dbd1639367)

### Hardware:

Source Code Path: `/hardware`
Components:

- SparkFun ESP32 Thing Plus-C
- Sparkfun BME680 Qwiic Breakout
- Arduino Framework
- PlatformIO

Instructions:

- Plug the BME680 into the ESP32 Thing Plus C with a Qwiic cable.
- If you're using a battery to power the development board, tick the 'Show Power' box in the Browser Client to show battery information from the onboard MAX17048 fuel gauge.

### Browser Client:

Source Code Path: `/app`

Contains a Docker config (via `docker-compose`) for running the PHP/Javascript web app at `http://localhost:8080`

Instructions:

- From the `/app` directory: `composer install && yarn install`
  - Copy the bootstrap and jquery files into `/app/public/<css|js>`
  - `composer update` will do this automatically (see post-update-command in composer.json)
- Update and install the git submodules `git submodule update --init --recursive`
- build the container `docker-compose up --build`
- Change the local IP in the souce code (TODO: add this to config)
- Connect to the web client at "http://localhost:8080/"

#### Changelog:

[6/10/23] - Added basic hardware and UI

#### TODO:

- [ ] add logging
- [ ] clean up web app
- [ ] complete PHP client and use json from same-domain client instead of loose CORS headers on ESP32
