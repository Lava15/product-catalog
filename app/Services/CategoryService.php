<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository
    ) {
    }

    public function createCategory(array $validatedData): Category
    {
        return Category::query()->create(
            [
                'name' => $validatedData['name']
            ]
        );
    }
    public function updateCategory(int $id, array $validatedData): Category
    {
        $category = $this->categoryRepository->findById($id);
        $category->update(
            [
                'name' => $validatedData['name']
            ]
        );
        return $category;
    }
}
