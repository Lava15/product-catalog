<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use App\Responses\MessageResponse;
use App\Http\Requests\ProductRequest;
use App\Responses\CollectionResponse;
use App\Repositories\ProductRepository;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ProductService $productService
    ) {
    }

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
    public function store(ProductRequest $request): MessageResponse
    {
        if ($request->validated()) {
            $product = $this->productService->storeProduct($request->validated());
            return new MessageResponse(
                message: 'Product created successfully',
                data: ProductResource::make($product),
                status: Response::HTTP_CREATED,
            );
        }
        return new MessageResponse(
            message: 'something went wrong',
            data: null,
            status: Response::HTTP_BAD_REQUEST,
        );
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
