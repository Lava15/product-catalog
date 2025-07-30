<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Responses\CollectionResponse;
use App\Http\Requests\CategoryRequest;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository
    ) {}

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
    public function store(CategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
