<?php 

namespace App\Utils;

use App\Http\Helpers\Request;
use App\Utils\HttpStatusCode;

class ValidationHandler
{
    public static function handler($validatorClass, $request)
    {
        if (method_exists($validatorClass, 'validate')) {
            $errors = $validatorClass::validate($request->getBody());
            if (!is_null($errors)) {
                Request::sendJsonResponse($errors, HttpStatusCode::HTTP_BAD_REQUEST);
            }
        }
        return;
           
    }
}