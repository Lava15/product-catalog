<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * @property-read Product $resource
     * @property-read Category $resource
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'type' => 'category',
            'private' => false,
            'attributes' => [
                'name' => $this->resource->name,
            ],
            'relationships' => [
                'products' => ProductResource::collection(
                    $this->whenLoaded('products')
                ),
            ],
        ];
    }
}
