<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use App\Responses\CollectionResponse;
use App\Http\Resources\ProductCollection;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\Response;

class ProductRepository
{
    protected function applyIncludes(Builder $query): Builder
    {
        if (request()->has('include')) {
            $includes = explode(',', request()->query('include'));
            $validIncludes = ['category'];
            $includes = array_intersect($includes, $validIncludes);

            if (!empty($includes)) {
                $query->with($includes);
            }
        }
        return $query;
    }

    public function getAllProducts(): CollectionResponse
    {
        $query = $this->applyIncludes($this->query());
        return new CollectionResponse(
            data: new ProductCollection($query->paginate(5)),
            status: Response::HTTP_OK
        );
    }

    public function findById(int $id): Product
    {
        $query = $this->applyIncludes($this->query());
        return $query->findOrFail($id);
    }
    public function getForExport(): array
    {
        return Product::with('category')
            ->get()
            ->map(function (Product $product) {
                return [
                    'name' => $product->name,
                    'barcode' => $product->barcode,
                    'price' => $product->price,
                    'category' => $product->category->name ?? 'Без категории',
                ];
            })->toArray();
    }
    private function query(): Builder
    {
        return Product::query();
    }
}
