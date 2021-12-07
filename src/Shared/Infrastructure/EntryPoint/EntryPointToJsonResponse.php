<?php

declare(strict_types=1);

namespace DevBodas\Shared\Infrastructure\EntryPoint;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EntryPointToJsonResponse
{

    /**
     * @param  array   $entity
     * @param  integer $code
     * @return JsonResponse
     */
    public function response(array $entity, int $code): JsonResponse
    {
        $jsonresponse = [
            'status' => $code,
            'data' => $entity
        ];

        return new JsonResponse($jsonresponse, $code);
    }

    /**
     * @param  string  $data
     * @param  integer $code
     * @return JsonResponse
     */
    public function error(string $data, int $code): JsonResponse
    {
        $jsonresponse = [
            'detail' => $data,
            'status' => $code
        ];
        return new JsonResponse($jsonresponse, $code);
    }

    /**
     * @return JsonResponse
     */
    public function unauthorizedError(): JsonResponse
    {
        return $this->error(
            'Unauthorized',
            Response::HTTP_UNAUTHORIZED
        );
    }
}
