<?php declare(strict_types=1);

use Application\Api\Controller\SensorController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {

    /** @uses SensorController::storeData() */
    $routes->add('api_push', '/api/push')
        ->defaults([
            '_controller' => SensorController::class,
            '_action' => 'storeData',
        ])
        ->methods(['POST']);

    /** @uses SensorController::readDataByIP() */
    $routes->add('api_read', '/api/sensor/read/{sensor_ip}')
        ->defaults([
            '_controller' => SensorController::class,
            '_action' => 'readDataByIP',
        ])
        ->methods(['GET']);

    /** @uses SensorController::getAverageData() */
    $routes->add('api_average', '/api/sensor/average')
        ->defaults([
            '_controller' => SensorController::class,
            '_action' => 'getAverageData',
        ])
        ->methods(['GET']);

    /** @uses SensorController::getHourData() */
    $routes->add('api_hour', '/api/sensor/hour')
        ->defaults([
            '_controller' => SensorController::class,
            '_action' => 'getHourData',
        ])
        ->methods(['GET']);
};