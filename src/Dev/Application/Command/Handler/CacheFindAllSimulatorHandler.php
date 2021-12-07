<?php

declare(strict_types=1);

namespace DevBodas\Dev\Application\Command\Handler;

use DevBodas\Dev\Application\Command\CacheFindAllSimulator;
use DevBodas\Dev\Domain\Repository\CacheSimulatorRepository;
use Exception;

class CacheFindAllSimulatorHandler
{
    private CacheSimulatorRepository $cacheRepository;
    private const UNIQUESIMULATOR = 'nuptic-43';

    /**
     *  FindSimulatorHandler constructor.
     *
     * @param CacheSimulatorRepository $cacheRepository
     */
    public function __construct(CacheSimulatorRepository $cacheRepository)
    {
        $this->cacheRepository = $cacheRepository;
    }

    /**
     * @param  CacheFindAllSimulator $command
     * @return array
     * @throws Exception
     */
    public function handle(CacheFindAllSimulator $command): array
    {
        $result = [];
        $cacheSimulator = $this->cacheRepository->findAll($command->id());
        if (count($cacheSimulator)>0) {
            foreach ($cacheSimulator as $simulator) {
                $array = json_decode($simulator, true, 512, JSON_THROW_ON_ERROR);
                if ($array['name'] === self::UNIQUESIMULATOR) {
                    $result[] = $array;
                }
            }
        }
        return $result;
    }
}
