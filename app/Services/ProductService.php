<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function storeProduct(array $validatedData): Product
    {
        return Product::query()->create([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'barcode' => $validatedData['barcode'],
            'category_id' => $validatedData['category_id'] ?? null,
        ]);
    }
}
