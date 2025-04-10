<?php 

namespace App\Http\Controllers\API\V1;

use App\Exceptions\NotFoundException;
use App\Http\Helpers\Request;
use App\Services\Products\CategoryService;
use App\Utils\HttpStatusCode;

class CategoryController 
{

    private $categoryService;

    public function __construct(CategoryService $categoryService) 
    {
        $this->categoryService = $categoryService;
    }
    
    public function index(): void
    {
        try {
            $response = [
                'status' => 'success',
                'data' => $this->categoryService->getAll(),
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
                'data' => $this->categoryService->getById($id),
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
                'data' => $this->categoryService->create($request->getBody())
            ];
            Request::sendJsonResponse($response, HttpStatusCode::HTTP_CREATED);

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

    public function update(Request $request, $id): void 
    {
        try {
            $response = [
                'status' => 'success',
                'data' => $this->categoryService->update($id, $request->getBody())
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

    public function delete($id): void 
    {
        try {
            $this->categoryService->delete($id);

            $response = [
                'status' => 'success',
            ];
            Request::sendJsonResponse($response, HttpStatusCode::HTTP_NO_CONTENT);
            
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