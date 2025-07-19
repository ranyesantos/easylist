<?php 

namespace App\Http\Controllers\API\V1;

use App\Http\Helpers\Request;
use App\Services\CategoryService;
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
        Request::sendJsonResponse($this->categoryService->getAll(), HttpStatusCode::HTTP_OK);
    }

    public function show(int $id): void
    {
        Request::sendJsonResponse($this->categoryService->getById($id), HttpStatusCode::HTTP_OK);
    }

    public function store(Request $request): void
    {
        Request::sendJsonResponse($this->categoryService->create($request->getBody()), HttpStatusCode::HTTP_CREATED);
    }

    public function update(Request $request, int $id): void 
    {
        Request::sendJsonResponse($this->categoryService->update($id, $request->getBody()), HttpStatusCode::HTTP_OK);
    }

    public function delete(int $id): void 
    {
        $this->categoryService->delete($id);
        Request::sendJsonResponse(null,HttpStatusCode::HTTP_NO_CONTENT);
    }
}