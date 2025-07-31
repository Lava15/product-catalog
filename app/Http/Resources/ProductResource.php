<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * @property-read Product $resource
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'type' => 'product',
            'private' => false,
            'attributes' => [
                'name' => $this->resource->name,
                'price' => $this->resource->price,
                'barcode' => $this->resource->barcode,
                'category_id' => $this->resource->category_id,
            ],
        ];
    }
}
