<?php

declare(strict_types=1);

namespace DevBodas\Dev\Infrastructure\EntryPoint\Controller;

use DateTime;
use DevBodas\Dev\Application\Command\CreateSimulator;
use DevBodas\Dev\Application\DataTransformer\SimulatorToArray;
use DevBodas\Shared\Infrastructure\EntryPoint\Controller\JwtAuthorizedController;
use DevBodas\Shared\Infrastructure\EntryPoint\EntryPointToJsonResponse;
use Exception;
use League\Tactician\CommandBus;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostSimulator extends JwtAuthorizedController
{
    private const LOGDIRECTION = 'este';

    /**
     * @throws Exception
     */
    public function __invoke(
        Request $request,
        CommandBus $commandBus,
        EntryPointToJsonResponse $responseFormat,
        SimulatorToArray $dataTransformer,
        LoggerInterface $logger
    ): JsonResponse {

        if (!$this->isAuthorised('admin', $request)) {
            return $responseFormat->unauthorizedError();
        }

        $param = json_decode($request->getContent(), true);

        if (!$this->paramsAreValid($param)) {
            return $responseFormat->error(
                'Valid data not provided in request body',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        $date = new DateTime();

        $simulator = new CreateSimulator(
            $param['id'] ?? null,
            $param['nameServer'],
            $param['number'],
            $param['direction'],
            $param['route'],
            $date->format('Y-m-d H:i:s'),
            $param['attempts']
        );

        try {
            $simulatorCreated = $commandBus->handle($simulator);
        }catch (Exception $e) {
            return $responseFormat->response(["data" => $e->getMessage()], $e->getCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $result = $dataTransformer->transform($simulatorCreated);
        if (strtolower($param['direction']) == self::LOGDIRECTION) {
            $logger->info(json_encode($result, JSON_THROW_ON_ERROR));
        }

        return $responseFormat->response(["data" => ['id' => $result['id']]], Response::HTTP_CREATED);
    }

    /**
     * @param  array|null $params
     * @return bool
     */
    private function paramsAreValid(?array $params): bool
    {
        if (!is_array($params)) {
            return false;
        }

        $requiredParams = [
            'nameServer' => fn ($name) => is_string($name),
            'direction' => fn ($direction) => is_string($direction),
            'route' => fn ($route) => is_int($route),
            'attempts' => fn ($route) => is_int($route)
        ];

        foreach ($requiredParams as $paramName => $isValidParam) {
            if (!array_key_exists($paramName, $params)) {
                return false;
            }

            if (!$isValidParam($params[$paramName])) {
                return false;
            }
        }

        return true;
    }
}
