<?php

namespace App\Validators;

use App\Exceptions\NotFoundException;
use App\Utils\HttpStatusCode;

class ExceptionHandler
{
    public function __construct(private $responseHandler)
    {}

    public function handle($controllerInstance, $action, $args = []): void
    {
        try {
            if (empty($args)) {
                $controllerInstance->$action();
            } elseif (is_array($args)) {
                $controllerInstance->$action(...$args);
            } else {
                $controllerInstance->$action($args);
            }

        } catch (NotFoundException $e) {
            $this->responseHandler->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], HttpStatusCode::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            $this->responseHandler->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
            
        } catch (\Throwable $e) {
            $this->responseHandler->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
