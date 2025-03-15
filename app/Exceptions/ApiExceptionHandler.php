<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ApiExceptionHandler
{
    public static function handle(Throwable $exception): JsonResponse
    {
        if ($exception instanceof AppException) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
                'data' => null,
            ]);
        }

        if ($exception instanceof AuthenticationException ) {
            return response()->json([
                'status' => false,
                'message' => "Bạn chưa đăng nhập",
                'data' => null,
            ], Response::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof ValidationException) {
            return response()->json([
                'status' => false,
                'message' => current($exception->errors())[0],
                'errors' => $exception->errors(),
                'data' => null,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy tài nguyên',
                'data' => null,
            ], Response::HTTP_NOT_FOUND);
        }

        $body = [
            'status' => false,
            'message' => $exception->getMessage() ?? 'Có lỗi gì đó, liên hệ admin để được hỗ trợ',
            'data' => null,
        ];

        if (app()->isLocal() && request()->has('debug')) {
            $body['location'] = $exception->getFile() . ':' . $exception->getLine();
            $body['trace'] = $exception->getTrace();
        }

        return response()->json($body, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
