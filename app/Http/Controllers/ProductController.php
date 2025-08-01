<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Exception;
use App\Responses\ErrorResponse;
use App\Services\ProductService;
use App\Responses\MessageResponse;
use App\Responses\CollectionResponse;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepository;
use App\Http\Requests\ProductFormRequest;
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
    public function store(ProductFormRequest $request): ErrorResponse|MessageResponse
    {
        if ($request->validated()) {
            $product = $this->productService->createProduct($request->validated());
            return new MessageResponse(
                message: 'Product created successfully',
                data: ProductResource::make($product),
                status: Response::HTTP_CREATED,
            );
        }
        return new ErrorResponse(
            e: new Exception('Failure in product creation'),
            message: 'something went wrong',
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): CollectionResponse|ErrorResponse
    {
        $product = $this->productRepository->findById($id);
        if (!$product) {
            return new ErrorResponse(
                e: new Exception('Product not found'),
                message: 'Product not found',
                status: Response::HTTP_NOT_FOUND
            );
        }
        return new CollectionResponse(
            data: ProductResource::make($product),
            status: Response::HTTP_OK
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductFormRequest $request, int $id): MessageResponse|ErrorResponse
    {
        $updatedProduct = $this->productService->updateProduct($id, $request->validated());
        if (!$updatedProduct) {
            return new ErrorResponse(
                e: new Exception('Product update failed'),
                message: 'Product update failed',
                status: Response::HTTP_BAD_REQUEST
            );
        }
        return new MessageResponse(
            message: 'Product updated successfully',
            data: ProductResource::make($updatedProduct),
            status: Response::HTTP_OK,
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): ErrorResponse|MessageResponse
    {
        $product = $this->productRepository->findById($id);
        if (!$product) {
            return new ErrorResponse(
                e: new Exception('Product not found'),
                message: 'Product not found',
                status: Response::HTTP_NOT_FOUND
            );
        }
        $product->delete();
        return new MessageResponse(
            message: 'Product deleted successfully',
            data: null,
            status: Response::HTTP_NO_CONTENT
        );
    }
    public function export(): MessageResponse
    {
        $fileName = $this->productService->exportToExcel();

        return new MessageResponse(
            message: 'Экспорт поставлен в очередь. Файл будет доступен для скачивания по ссылке ниже, когда экспорт завершится.',
            data: [
                'file' => $fileName,
                'download_url' => route('export.download', ['file' => $fileName]),
                'status_check' => route('export.status', ['file' => $fileName])
            ],
            status: Response::HTTP_ACCEPTED
        );
    }
}
