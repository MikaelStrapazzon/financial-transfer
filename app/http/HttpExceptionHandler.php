<?php

namespace App\http;

use App\exceptions\InternalServerErrorException;
use App\Exceptions\NotFoundException;
use App\exceptions\UnauthorizedTransferException;
use App\http\responses\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

class HttpExceptionHandler
{
    public static function newHttpExceptionRender(Throwable $e): JsonResponse
    {
        if (
            $e instanceof NotFoundException ||
            $e instanceof InternalServerErrorException ||
            $e instanceof UnauthorizedTransferException
        ) {
            return HttpResponse::error(
                $e->getMessage(),
                statusCode: $e->getCode());
        }

        if ($e instanceof ValidationException) {
            return HttpResponse::error(
                $e->getMessage(),
                $e->errors(),
                422);
        }

        return HttpResponse::error(
            'Internal Server Error',
            statusCode: 500);
    }
}
