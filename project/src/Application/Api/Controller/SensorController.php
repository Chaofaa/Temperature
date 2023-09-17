<?php

namespace Application\Api\Controller;

use Entity\Sensor;
use Ramsey\Uuid\Uuid;
use Repository\SensorRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class SensorController extends BaseController {

    public function __construct(
        private SensorRepository $sensorRepository,
    ) {}

    public function storeData(Request $request): JsonResponse
    {
        if ($request->headers->get('Content-Type') !== 'application/json') {
            return $this->errorResponse('Accept only Json');
        }

        $ip_address = $request->getClientIp();

        $data = json_decode($request->getContent(), true);

        $sensor = new Sensor();
        $sensor->setUuid($data['reading']['sensor_uuid']);
        $sensor->setTemperature($data['reading']['temperature']);
        $sensor->setTemperatureType(Sensor::TEMPERATURE_TYPE_CELSIUS);
        $sensor->setIpAddress($ip_address);

        $this->sensorRepository->store($sensor);

        return $this->successResponse('Saved');
    }

    public function readDataByIP(Request $request): JsonResponse
    {
        $ipAddress = $request->get('sensor_ip');
        if ($ipAddress === null) {
            return $this->errorResponse('sensor_ip - is not specified');
        }

        $sensor = $this->sensorRepository->findByIp($ipAddress);

        if ($sensor === null) {
            // create new & add random data.
            $sensor = new Sensor();
            $sensor->setUuid(Uuid::uuid4());
            $sensor->setTemperature(random_int(1, 80));
            $sensor->setTemperatureType(Sensor::TEMPERATURE_TYPE_CELSIUS);
            $sensor->setIpAddress($ipAddress);

            $this->sensorRepository->store($sensor);
        }

        $sensor = $this->sensorRepository->increaseReadingId($sensor);

        return $this->successResponse([
            'sensor_uuid' => $sensor->getUuid(),
            'sensor_ip' => $sensor->getIpAddress(),
            'sensor_data' => implode(', ', [
                $sensor->getReadingId(),
                $sensor->getOutputTemperature()
            ])
        ]);
    }

    public function getAverageData(): JsonResponse
    {
        return $this->successResponse('getAverageData');
    }

    public function getHourData(): JsonResponse
    {
        return $this->successResponse('getHourData');
    }

}