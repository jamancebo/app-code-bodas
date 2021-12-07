<?php

declare(strict_types=1);

namespace DevBodas\Dev\Application\Command;

class CreateSimulator
{
    private ?string $id;
    private string $name;
    private int $number;
    private string $direction;
    private int $route;
    private string $date;
    private int $attempts;


    /**
     * Simulator constructor.
     *
     * @param String|null $id
     * @param String      $name
     * @param Int         $number
     * @param String      $direction
     * @param Int         $route
     * @param String      $date
     * @param Int         $attempts
     */
    public function __construct(
        ?String $id,
        String $name,
        Int $number,
        String $direction,
        Int $route,
        String $date,
        int $attempts
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->number = $number;
        $this->direction = $direction;
        $this->route = $route;
        $this->date = $date;
        $this->attempts = $attempts;
    }

    /**
     * @return String|null
     */
    public function id(): ?String
    {
        return $this->id ?? null;
    }

    /**
     * @return String
     */
    public function name(): String
    {
        return $this->name;
    }

    /**
     * @return Int
     */
    public function number(): Int
    {
        return $this->number;
    }

    /**
     * @return String
     */
    public function direction(): String
    {
        return $this->direction;
    }

    /**
     * @return Int
     */
    public function route(): Int
    {
        return $this->route;
    }

    /**
     * @return String
     */
    public function date(): String
    {
        return $this->date;
    }

    /**
     * @return Int
     */
    public function attempts(): Int
    {
        return $this->attempts;
    }

}
