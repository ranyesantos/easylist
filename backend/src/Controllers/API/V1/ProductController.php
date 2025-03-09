<?php

namespace App\Controllers\API\V1;

use App\Http\Request;
use App\Services\Products\ProductService;
use App\Utils\HttpStatusCode;

class ProductController 
{

    private $productService;

    public function __construct(
        ProductService $productService
    ) 
    {
        $this->productService = $productService;
    }

    public function index()
    {
        try {
            $response = [
                'status' => 'success',
                'data' => $this->productService->getAll(),
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

    public function show($id) 
    {
        try {
            $response = [
                'status' => 'success',
                'data' => $this->productService->getById($id),
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

    public function store(Request $request) 
    {
        try {
            $response = [
                'status' => 'success',
                'data' => $this->productService->create($request->getBody())
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

    public function update(Request $request, $id) 
    {
        
        try {
            $response = [
                'status' => 'success',
                'data' => $this->productService->update($id, $request->getBody())
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

    public function delete($id) 
    {
        try {
            $response = [
                'status' => 'success',
                'data' => $this->productService->delete($id),
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
}
