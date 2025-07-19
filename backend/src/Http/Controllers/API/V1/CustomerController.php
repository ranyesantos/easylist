<?php

namespace App\Http\Controllers\API\V1;

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
        Request::sendJsonResponse($this->customerService->getAll(), HttpStatusCode::HTTP_OK);
    }

    public function show(int $id): void 
    {
        Request::sendJsonResponse($this->customerService->getById($id), HttpStatusCode::HTTP_OK);
    }

    public function store(Request $request): void 
    {
        Request::sendJsonResponse($this->customerService->create($request->getBody()), HttpStatusCode::HTTP_OK);
    }

    public function update(Request $request, int $id): void 
    {
        Request::sendJsonResponse($this->customerService->update($id, $request->getBody()), HttpStatusCode::HTTP_OK);
    }

    public function delete(int $id): void 
    {
        $this->customerService->delete($id);

        Request::sendJsonResponse(null, HttpStatusCode::HTTP_NO_CONTENT);
    }
}
