<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Resources\CategoryResource;
use App\Models\Product;
use App\Models\Category;
use App\Responses\CollectionResponse;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;

class CategoryRepository
{
    public function getAllCategories(): CollectionResponse
    {
        return new CollectionResponse(
            data: CategoryResource::collection(Category::query()->paginate(5)),
            status: Response::HTTP_OK
        );
    }
    public function findById(int $id): Category
    {
        return Category::query()->findOrFail($id);
    }
}
