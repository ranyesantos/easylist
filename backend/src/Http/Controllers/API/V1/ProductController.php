<?php

namespace App\Http\Controllers\API\V1;

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
        Request::sendJsonResponse($this->productService->getAll(), HttpStatusCode::HTTP_OK);
    }

    public function show(int $id): void
    {
        Request::sendJsonResponse($this->productService->getById($id), HttpStatusCode::HTTP_OK);
    }

    public function store(Request $request): void
    {
        Request::sendJsonResponse($this->productService->create($request->getBody()), HttpStatusCode::HTTP_OK);
    }

    public function update(Request $request, int $id): void
    {
        Request::sendJsonResponse($this->productService->update($id, $request->getBody()), HttpStatusCode::HTTP_OK);
    }

    public function delete(int $id): void
    {
        $this->productService->delete($id);

        Request::sendJsonResponse(null, HttpStatusCode::HTTP_NO_CONTENT);
    }
}
