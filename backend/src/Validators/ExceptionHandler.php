<?php

namespace App\Validators;

use App\Exceptions\NotFoundException;
use App\Http\Helpers\Request;
use App\Utils\HttpStatusCode;

class ExceptionHandler
{
    public static function handle($controllerInstance, $action, $params = null): void
    {
        try {
          $params ? $controllerInstance->$action() : $controllerInstance->$action($params);

        } catch (NotFoundException $e) {
            Request::sendJsonResponse([
                'status' => 'error',
                'message' => $e->getMessage()
            ], HttpStatusCode::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            Request::sendJsonResponse([
                'status' => 'error',
                'message' => $e->getMessage()
            ], HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
            
        } catch (\Throwable $e) {
            Request::sendJsonResponse([
                'status' => 'error',
                'message' => $e->getMessage()
            ], HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
