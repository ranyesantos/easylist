<?php

namespace App\Http\Controllers\API\V1;

use App\Exceptions\NotFoundException;
use App\Http\Helpers\Request;
use App\Services\ProductService;
use App\Utils\HttpStatusCode;

class ProductController
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(): void
    {
        try {
            $response = [
                'status' => 'success',
                'data' => $this->productService->getAll(),
            ];
            Request::sendJsonResponse($response, HttpStatusCode::HTTP_OK);
        } catch (\Exception $e) {
            Request::sendJsonResponse([
                'status' => 'error',
                'message' => $e->getMessage()
            ], HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(int $id): void
    {
        try {
            $response = [
                'status' => 'success',
                'data' => $this->productService->getById($id),
            ];
            Request::sendJsonResponse($response, HttpStatusCode::HTTP_OK);
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
        }
    }

    public function store(Request $request): void
    {
        try {
            $response = [
                'status' => 'success',
                'data' => $this->productService->create($request->getBody())
            ];
            Request::sendJsonResponse($response, HttpStatusCode::HTTP_OK);
        } catch (\Exception $e) {
            Request::sendJsonResponse([
                'status' => 'error',
                'message' => $e->getMessage()
            ], HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, int $id): void
    {
        try {
            $response = [
                'status' => 'success',
                'data' => $this->productService->update($id, $request->getBody())
            ];
            Request::sendJsonResponse($response, HttpStatusCode::HTTP_OK);
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
        }
    }

    public function delete(int $id): void
    {
        try {
            $this->productService->delete($id);
            Request::sendJsonResponse([
                'status' => 'success',
                'message' => 'Produto excluído com sucesso.'
            ], HttpStatusCode::HTTP_OK);
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
        }
    }
}
