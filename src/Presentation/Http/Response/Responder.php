<?php

namespace Core\Presentation\Http\Response;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Laravel\Octane\Exceptions\DdException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Responder
{
    public static function ok(string $message = 'Thao tác thành công.'): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => null,
        ]);
    }

    public static function success(array|object|null $data = [], string $message = 'Thao tác thành công.'): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public static function fail(string $message = '', array|object|null $data = [], ?int $httpCode = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $httpCode ?? Response::HTTP_OK);
    }

    /**
     * @throws Throwable
     * @throws DdException
     */
    public static function failWithException(
        Throwable $exception,
        ?string $message = null,
        array|object|null $data = null,
        ?int $httpCode = null
    ): JsonResponse {
        if ($exception instanceof DdException) {
            throw $exception;
        }
        $message ??= $exception->getMessage();
        $httpCode ??= match (true) {
            $exception instanceof AuthenticationException => Response::HTTP_UNAUTHORIZED,
            default => Response::HTTP_INTERNAL_SERVER_ERROR
        };

        $body = [
            'success' => false,
            'message' => $message,
            'data' => $data,
        ];

        if (!app()->isProduction()) {
            $body['location'] = $exception->getFile() . ':' . $exception->getLine();
            $body['trace'] = $exception->getTrace();
        }

        return response()->json($body, $httpCode);
    }

    public static function jsonObject(array|null $data): ?object
    {
        return $data !== null ? (object)$data : null;
    }

    public static function jsonArray(mixed $data): array
    {
        if (!is_array($data)) {
            return [];
        }
        return array_values($data);
    }
}
