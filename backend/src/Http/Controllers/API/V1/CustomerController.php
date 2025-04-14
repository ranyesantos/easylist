<?php

namespace App\Http\Controllers\API\V1;

use App\Exceptions\NotFoundException;
use App\Http\Helpers\Request;
use App\Services\CustomerService;
use App\Utils\HttpStatusCode;

class CustomerController
{

    private $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index(): void
    {
        try {
            $response = [
                'status' => 'success',
                'data' => $this->customerService->getAll(),
            ];
            Request::sendJsonResponse($response, HttpStatusCode::HTTP_OK);
        
        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
            Request::sendJsonResponse($response, HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
        
    }

    public function show(int $id): void 
    {
        try {
            $response = [
                'status' => 'success',
                'data' => $this->customerService->getById($id),
            ];
            Request::sendJsonResponse($response, HttpStatusCode::HTTP_OK);
            
        } catch (NotFoundException $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
            Request::sendJsonResponse($response, HttpStatusCode::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
            Request::sendJsonResponse($response, HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request): void 
    {
        try {
            $response = [
                'status' => 'success',
                'data' => $this->customerService->create($request->getBody())
            ];
            Request::sendJsonResponse($response, HttpStatusCode::HTTP_OK);
            
        } catch (NotFoundException $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
            Request::sendJsonResponse($response, HttpStatusCode::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
            Request::sendJsonResponse($response, HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, int $id): void 
    {
        try {
            $response = [
                'status' => 'success',
                'data' => $this->customerService->update($id, $request->getBody())
            ];
            Request::sendJsonResponse($response, HttpStatusCode::HTTP_OK);
            
        } catch (NotFoundException $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
            Request::sendJsonResponse($response, HttpStatusCode::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
            Request::sendJsonResponse($response, HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(int $id): void 
    {
        try {
            $response = [
                'status' => 'success',
                'data' => $this->customerService->delete($id),
            ];
            Request::sendJsonResponse($response, HttpStatusCode::HTTP_OK);

        } catch (NotFoundException $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
            Request::sendJsonResponse($response, HttpStatusCode::HTTP_NOT_FOUND);
        
        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
            Request::sendJsonResponse($response, HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
