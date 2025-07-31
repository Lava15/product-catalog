<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Responses\CollectionResponse;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\Response;

class CategoryRepository
{
    protected function applyIncludes(Builder $query): Builder
    {
        if (request()->has('include')) {
            $includes = explode(',', request()->query('include'));
            $validIncludes = ['products'];
            $includes = array_intersect($includes, $validIncludes);
            
            if (!empty($includes)) {
                $query->with($includes);
            }
        }
        return $query;
    }

    public function getAllCategories(): CollectionResponse
    {
        $query = $this->applyIncludes($this->query());
        return new CollectionResponse(
            data: new CategoryCollection($query->paginate(5)),
            status: Response::HTTP_OK
        );
    }

    public function findById(int $id): Category
    {
        $query = $this->applyIncludes($this->query());
        return $query->findOrFail($id);
    }
    private function query(): Builder
    {
        return Category::query();
    }
}
