<?php

namespace Application\Api\Controller;

use Symfony\Component\HttpFoundation\Request;

final class SensorController extends BaseController {

    public function storeData(Request $request)
    {
        return $this->successResponse('storeData');
    }

    public function readDataByIP(Request $request)
    {
        dd($request);
        return $this->successResponse('readDataByIP');
    }

    public function getAverageData()
    {
        return $this->successResponse('getAverageData');
    }

    public function getHourData()
    {
        return $this->successResponse('getHourData');
    }

}