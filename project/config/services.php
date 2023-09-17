<?php declare(strict_types=1);

use Application\Api\Controller\SensorController;
use Factory\PdoFactory;
use Psr\Container\ContainerInterface;
use Repository\SensorRepository;

return [
    SensorController::class => static function (ContainerInterface $container) {
        return new SensorController(
            $container->get(SensorRepository::class)
        );
    },

    PDO::class => static function () {
        return PdoFactory::create('pgsql:host=eco-finance-postgres;port=5432;dbname=eco_finance;user=postgres;password=postgres-password');
    },

    SensorRepository::class => static function (ContainerInterface $container) {
        return new SensorRepository(
            $container->get(PDO::class)
        );
    },

];