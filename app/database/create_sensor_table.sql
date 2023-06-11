/**
    Creates the logging table to hold historical sensor data.
**/

begin;

create table bme680_sensor_data
(
    id serial not null,
    "time" timestamp without time zone,
    iaq numeric,
    iaq_accuracy boolean,
    static_iaq numeric,
    co2_equivalent numeric,
    breath_voc_equivalent numeric,
    temperature_raw numeric,
    temperature_comp numeric,
    pressure numeric,
    humidity_raw numeric,
    humidity_comp numeric,
    gas numeric,
    status_stab boolean,
    status_run_in boolean,
    uptime integer,
    primary key (id)
);

create index on bme680_sensor_data (time);

commit;
