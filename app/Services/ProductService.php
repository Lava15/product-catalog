<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductService
{
    public function __construct(
        private readonly ProductRepository $productRepository
    ) {}

    public function createProduct(array $validatedData): Product
    {
        return Product::query()->create([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'barcode' => $validatedData['barcode'] ?? null,
            'category_id' => $validatedData['category_id'] ?? null,
        ]);
    }
    public function updateProduct(int $id, array $validatedData)
    {
        $product = $this->productRepository->findById($id);
        $product->update([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'barcode' => $validatedData['barcode'] ?? null,
            'category_id' => $validatedData['category_id'] ?? null,
        ]); 
        return $product;
    }
}
