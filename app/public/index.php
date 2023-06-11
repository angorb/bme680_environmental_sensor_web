<?php

declare(strict_types=1);

include __DIR__ . '/../config/rc.php';

use Angorb\EnvironmentalSensor\Template;
use Middlewares\Whoops;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$requestLogger = new Monolog\Logger('index.php');
$requestLogger->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . '/../log/request.log'));

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$router = new League\Route\Router();

// Add error handling middleware
$whoops = (new \Whoops\Run())
    ->prependHandler(new \Whoops\Handler\PrettyPageHandler())
    ->register();
$router->middleware(new Whoops($whoops));

$responseFactory = new Laminas\Diactoros\ResponseFactory();

// map a route
$router->map('GET', '', function (ServerRequestInterface $request): ResponseInterface {
    return new \Laminas\Diactoros\Response\HtmlResponse(Template::renderStatic('view', []));
});

$router->map('GET', '/api/list', function (ServerRequestInterface $request, array $args): array {
    return NoteStreamController::listStreams();
})->setStrategy(new League\Route\Strategy\JsonStrategy($responseFactory));

try {
    $response = $router->dispatch($request);
    // send the response to the browser
    (new Laminas\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);
} catch (Exception $ex) {
    // TODO stop assuming any exception is a 404!
    $requestLogger->critical(
        $ex->getMessage(),
        [
            'url' => $request->getRequestTarget(),
            'body' => $request->getBody()->getContents(),
            'headers' => $request->getHeaders()
        ]
    );

    $notFoundResponse = new \Laminas\Diactoros\Response\HtmlResponse(Template::renderStatic(
        '404',
        ['uri' => $request->getRequestTarget()]
    ));
    (new Laminas\HttpHandlerRunner\Emitter\SapiEmitter())->emit($notFoundResponse);
}
