<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Responses\CollectionResponse;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): CollectionResponse
    {
        return $this->productRepository->getAllProducts();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
