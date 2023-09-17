<?php declare(strict_types=1);

use Application\Api\Controller\SensorController;
use Psr\Container\ContainerInterface;

return [
    SensorController::class => static function (ContainerInterface $container) {
        return new SensorController($container);
    }

];