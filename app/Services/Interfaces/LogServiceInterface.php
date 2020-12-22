<?php


namespace App\Services\Interfaces;


interface LogServiceInterface
{
    /**
     * @return array
     */
    public function getLogs():array;

    /**
     * @param string $date
     * @return array
     */
    public function getStatusByDate(string $date): array;
}
