<?php

namespace App\Entities\Logs\Repositories\Interfaces;

use App\Entities\Logs\Log;
use App\Entities\Logs\Repositories\Interfaces\LogRepositoryInterface;
use Illuminate\Database\QueryException;

class LogRepository implements LogRepositoryInterface{
    private $columns = ['id', 'type', 'value'];

    public function __construct(Log $log)
    {
        $this->model = $log;
    }

    public function listLogs()
    {
        try {
            return  $this->model
                ->get($this->columns);
        } catch (QueryException $e) {
            abort(503, $e->getMessage());
        }
    }

    public function createLog(array $data)
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $e) {
            abort(503, $e->getMessage());
        }
    }
}
