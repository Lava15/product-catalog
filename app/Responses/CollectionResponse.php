<?php

declare(strict_types=1);

namespace App\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CollectionResponse implements Responsable
{
    public function __construct(
        private readonly mixed $data,
        private int|Response $status = Response::HTTP_OK,
    ) {
        
    }
    public function toResponse($request): JsonResponse
    {
        return new JsonResponse([
            'data' => $this->data,
            'status' => $this->status,
        ]);
    }
}
