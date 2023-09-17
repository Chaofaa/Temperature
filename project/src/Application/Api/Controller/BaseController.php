<?php

namespace Application\Api\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController {

    protected function successResponse(array|string $data): JsonResponse
    {
        return new JsonResponse([
            'data' => $data,
            'status' => 'success'
        ]);
    }

    protected function errorResponse(array|string $messages): JsonResponse
    {
        if (! is_array($messages)) {
            $messages = [ $messages ];
        }

        return new JsonResponse([
            'messages' => $messages,
            'status' => 'error'
        ]);
    }

}