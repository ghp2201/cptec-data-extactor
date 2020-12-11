<?php

namespace App\Exporters;

use App\Models\MinTemperature;
use App\Models\MaxTemperature;

class Exporter
{
    private $model;

    public function export($kind)
    {
        $this->setModelFromKind($kind);

        return $this->model::all()->toJson();
    }

    private function setModelFromKind($kind)
    {
        if ($kind == 'tempmin') {
            $this->model = new MinTemperature;
        } else if ($kind == 'tempmax') {
            $this->model = new MaxTemperature;
        }
    }
}
