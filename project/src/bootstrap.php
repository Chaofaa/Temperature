<?php

use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

require __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('UTC');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: origin, content-type, country');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT, PATCH');

// DI
$containerBuilder = new DI\ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/../config/services.php');
$container = $containerBuilder->build();

// Run migration -> fast solution
if (php_sapi_name() === "cli") {
    echo 'creating database' . PHP_EOL;

    require __DIR__ . '/../migrations/CreateStructureAction.php';
    (new CreateStructureAction($container->get(PDO::class)))->execute();

    echo 'database created' . PHP_EOL;
    exit;
}

$locator = new FileLocator(__DIR__ . '/../config');

// Request
$request = Request::createFromGlobals();

// Routes
$context = new RequestContext();
$context->fromRequest($request);

$phpFileLoader = new PhpFileLoader($locator);

$matcher = new UrlMatcher(
    $phpFileLoader->load('routes.php'),
    $context
);


// Dispatch
try {
    $attributes = $matcher->match($request->getPathInfo());

    foreach ($attributes as $key => $value) {
        $request->attributes->set($key, $value);
    }

    $controller = $attributes['_controller'];
    $action = $attributes['_action'];

    $response = $container->get($controller)->{$action}($request);
} catch (Throwable $exception) {
    $response = new JsonResponse([
        'message' => $exception->getMessage(),
        'status' => 'error'
    ]);
}

$response->send();