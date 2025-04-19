<?php 

namespace App\Http\Controllers\API\V1;

use App\Exceptions\NotFoundException;
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
        try {
            $response = [
                'status' => 'success',
                'data' => $this->sizeService->getAll(),
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
                'data' => $this->sizeService->getById($id),
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
                'data' => $this->sizeService->create($request->getBody())
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
                'data' => $this->sizeService->update($id, $request->getBody())
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
            $this->sizeService->delete($id);
            Request::sendJsonResponse([
                'status' => 'success',
                'message' => 'Tamanho excluído com sucesso.'
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
