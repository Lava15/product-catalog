<?php

declare(strict_types=1);

namespace App\Responses;

use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use Symfony\Component\HttpFoundation\Response;

class ErrorResponse implements Responsable
{
    public function __construct(
        private readonly Throwable $e,
        private readonly string $message,
        private readonly array $headers = [],
        private readonly int|Response $status = Response::HTTP_INTERNAL_SERVER_ERROR
    ) {
    }

    public function toResponse($request): JsonResponse
    {
        $response = ['message' => $this->message];

        if ($this->e && config('app.debug')) {
            $response['debug'] = [
                'message' => $this->e->getMessage(),
                'file' => $this->e->getFile(),
                'line' => $this->e->getLine(),
                'trace' => $this->e->getTraceAsString(),
            ];
        }

        return new JsonResponse(
            data: $response,
            status: $this->status,
            headers: $this->headers,
        );
    }
}
