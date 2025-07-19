<?php 

namespace App\Http\Controllers\API\V1;

use App\Http\Helpers\Request;
use App\Services\ColorService;
use App\Utils\HttpStatusCode;

class ColorController 
{

    private $colorService;

    public function __construct(
        ColorService $colorService
    )
    {
        $this->colorService = $colorService;
    }

    public function index(): void
    {
        Request::sendJsonResponse($this->colorService->getAll(), HttpStatusCode::HTTP_OK);
    }

    public function show(int $id): void 
    {
        Request::sendJsonResponse($this->colorService->getById($id), HttpStatusCode::HTTP_OK);
    }

    public function store(Request $request): void 
    {
        Request::sendJsonResponse($this->colorService->create($request->getBody()), HttpStatusCode::HTTP_OK);
    }

    public function update(Request $request, int $id): void 
    {
        Request::sendJsonResponse($this->colorService->update($id, $request->getBody()), HttpStatusCode::HTTP_OK);
    }

    public function delete(int $id): void 
    {
        $this->colorService->delete($id);

        Request::sendJsonResponse(null, HttpStatusCode::HTTP_OK);
    }

}