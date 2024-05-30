<?php

namespace App\http\responses;

use Illuminate\Http\JsonResponse;

class HttpResponse
{
    public static function success(
        array $data,
        string $message = 'Operation successful',
        int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    public static function error(
        string $message,
        ?array $errors = null,
        int $statusCode = 400): JsonResponse
    {
        $response = [
            'status' => 'error',
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }
}
