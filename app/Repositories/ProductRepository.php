<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use App\Responses\CollectionResponse;
use App\Http\Resources\ProductResource;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;

class ProductRepository
{
    public function getAllProducts(): CollectionResponse
    {
        return new CollectionResponse(
            data: ProductResource::collection(Product::query()->paginate(5)),
            status: Response::HTTP_OK
        );
        
    }
}
