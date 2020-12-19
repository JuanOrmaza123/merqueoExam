<?php

namespace App\Entities\Logs\Repositories\Interfaces;

interface LogRepositoryInterface{
    public function listLogs();

    public function createLog(array $data);
}
