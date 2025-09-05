<?php 

namespace App\Http\Controllers\API\V1;

use App\Http\Helpers\Request;
use App\Services\SizeService;
use App\Utils\HttpStatusCode;

class SizeController 
{
    private SizeService $sizeService;

    public function __construct(SizeService $sizeService)
    {
        $this->sizeService = $sizeService;
    }

    public function index(): void
    {
        Request::sendJsonResponse($this->sizeService->getAll(), HttpStatusCode::HTTP_OK);
    }

    public function show(int $id): void 
    {
        Request::sendJsonResponse($this->sizeService->getById($id), HttpStatusCode::HTTP_OK);
    }

    public function store(Request $request): void 
    {
        Request::sendJsonResponse($this->sizeService->create($request->getBody()), HttpStatusCode::HTTP_OK);
    }

    public function update(Request $request, int $id): void 
    {
        Request::sendJsonResponse($this->sizeService->update($id, $request->getBody()), HttpStatusCode::HTTP_OK);
    }

    public function delete(int $id): void 
    {
        $this->sizeService->delete($id);

        Request::sendJsonResponse(null, HttpStatusCode::HTTP_NO_CONTENT);
    }
}
