# bme680_environmental_sensor_web

A simple asynchronous HTTP web client and server for the Bosch Sensortec BME680.

<img width="1351" alt="image" src="https://github.com/angorb/bme680_environmental_sensor_web/assets/17731071/9424280f-1c55-4c76-88a7-505015b74912">

### Hardware:
see: `/hardware`
Uses:
- SparkFun ESP32 Thing Plus-C
- Sparkfun BME680 Qwiic Breakout
- Arduino Framework
- B

### Browser Client:
see: `/app`6-
Contains Docker config (via `docker-compose`) for running the PHP/Javascript web app at `http://localhost:8080`
Instructions:
- From the `/app` directory: `composer install && yarn install`
  - Copy the bootstrap and jquery files into `/app/public/<css|js>`
  - `composer update` will do this automatically (see post-update-command in composer.json)
- Update and install the git submodules `git submodule update --init --recursive`
- build the container `docker-compose up --build`

#### Changelog:
[6/10/23] - Added basic hardware and UI

#### TODO:
- [ ] add logging
- [ ] clean up web app
- [ ] complete PHP client and use json from same-domain client instead of loose CORS headers on ESP32