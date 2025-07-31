<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use App\Responses\ErrorResponse;
use App\Services\CategoryService;
use App\Responses\MessageResponse;
use App\Responses\CollectionResponse;
use App\Http\Resources\CategoryResource;
use App\Repositories\CategoryRepository;
use App\Http\Requests\CategoryFormRequest;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly CategoryService $categoryService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): CollectionResponse
    {
        return $this->categoryRepository->getAllCategories();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryFormRequest $request)
    {
        if ($request->validated()) {
            $category = $this->categoryService->createCategory($request->validated());
            return new MessageResponse(
                message: 'Category created successfully',
                data: CategoryResource::make($category),
                status: Response::HTTP_CREATED,
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): CollectionResponse|ErrorResponse
    {
        $category = $this->categoryRepository->findById($id);
        if (!$category) {
            return new ErrorResponse(
                e: new Exception('Category not found'),
                message: 'Category not found',
                status: Response::HTTP_NOT_FOUND
            );
        }
        return new CollectionResponse(
            data: CategoryResource::make($category),
            status: Response::HTTP_OK
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryFormRequest $request, int $id): MessageResponse|ErrorResponse
    {
        $updatedCategory = $this->categoryService->updateCategory($id, $request->validated());
        if (!$updatedCategory) {
            return new ErrorResponse(
                e: new Exception('Category update failed'),
                message: 'Failed to update category',
                status: Response::HTTP_BAD_REQUEST
            );
        }
        return new MessageResponse(
            message: 'Category updated successfully',
            data: CategoryResource::make($updatedCategory),
            status: Response::HTTP_OK,
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): MessageResponse|ErrorResponse
    {
        $category = $this->categoryRepository->findById($id);
        if (!$category) {
            return new ErrorResponse(
                e: new Exception('Category not found'),
                message: 'Category not found',
                status: Response::HTTP_NOT_FOUND
            );
        }
        $category->delete();
        return new MessageResponse(
            message: 'Category deleted successfully',
            data: null,
            status: Response::HTTP_NO_CONTENT
        );
    }
}
