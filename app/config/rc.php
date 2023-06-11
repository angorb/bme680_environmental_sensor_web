<?php

declare(strict_types=1);

include __DIR__ . '/../vendor/autoload.php';

$requestLogger = new Monolog\Logger('app');
$requestLogger->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . '/../log/app.log'));
