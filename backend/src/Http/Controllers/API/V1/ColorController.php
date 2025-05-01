<?php 

namespace App\Http\Controllers\API\V1;

use App\Exceptions\NotFoundException;
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
        try {
            $response = [
                'status' => 'success',
                'colors' => $this->colorService->getAll(),
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
                'data' => $this->colorService->getById($id),
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
                'data' => $this->colorService->create($request->getBody())
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
                'data' => $this->colorService->update($id, $request->getBody())
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
                'data' => $this->colorService->delete($id),
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