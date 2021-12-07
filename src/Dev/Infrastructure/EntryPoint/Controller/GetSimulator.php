<?php

declare(strict_types=1);

namespace DevBodas\Dev\Infrastructure\EntryPoint\Controller;

use DevBodas\Dev\Application\Command\CacheFindAllSimulator;
use DevBodas\Dev\Application\Command\FindAllSimulator;
use DevBodas\Dev\Application\DataTransformer\SimulatorToArray;
use DevBodas\Shared\Infrastructure\EntryPoint\Controller\JwtAuthorizedController;
use DevBodas\Shared\Infrastructure\EntryPoint\EntryPointToJsonResponse;
use Exception;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetSimulator extends JwtAuthorizedController
{
    /**
     * @param  string                   $id
     * @param  Request                  $request
     * @param  CommandBus               $commandBus
     * @param  EntryPointToJsonResponse $responseFormat
     * @param  SimulatorToArray         $dataTransformer
     * @return JsonResponse
     */
    public function __invoke(
        string $id,
        Request $request,
        CommandBus $commandBus,
        EntryPointToJsonResponse $responseFormat,
        SimulatorToArray $dataTransformer
    ): JsonResponse {

        if (!$this->isAuthorised('admin', $request)) {
            return $responseFormat->unauthorizedError();
        }

        $cacheFindSimulator = new CacheFindAllSimulator($id);
        try {
            $result = $commandBus->handle($cacheFindSimulator);
        } catch (Exception $e) {
            return $responseFormat->response(
                ["data" => $e->getMessage()],
                $e->getCode() ??  Response::HTTP_BAD_REQUEST
            );
        }

        if (count($result) === 0) {
            $findSimulator = new FindAllSimulator($id);
            try {
                $simulatorsFound = $commandBus->handle($findSimulator);
            } catch (Exception $e) {
                return $responseFormat->response(
                    ["data" => $e->getMessage()],
                    $e->getCode() ??  Response::HTTP_BAD_REQUEST
                );
            }

            foreach ($simulatorsFound as $simulator) {
                $result[] = $dataTransformer->transform($simulator);
            }
        }


        return $responseFormat->response($result, Response::HTTP_OK);
    }
}
