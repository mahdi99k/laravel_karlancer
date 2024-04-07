<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{

    protected function successResponse($code = 200, $data, $message = null): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse($code, $message = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null
        ], $code);
    }

}
