<?php

use Illuminate\Support\Facades\Response;

Response::macro('success', function ($message, array $data = null, $httpCode = 200) {
    return response()->json([
        'success' => true,
        'message' => $message,
        'data' => $data
    ], $httpCode);
});

Response::macro('error', function ($message, $httpCode = 400) {
    return response()->json([
        'success' => false,
        'error' => $message
    ], $httpCode);
});