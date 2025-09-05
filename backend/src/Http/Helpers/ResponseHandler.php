<?php

namespace App\Http\Helpers;

class ResponseHandler
{
    public function json($data, $statusCode): void
    {
        Request::sendJsonResponse($data, $statusCode);
    }
}