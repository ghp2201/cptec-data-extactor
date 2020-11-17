<?php

namespace App\Exporters;

use App\Models\MinTemperature;
use App\Models\MaxTemperature;

class Exporter
{
    private $kind, $model;

    public function init($kind)
    {
        $this->kind = $kind;

        $this->validateKind();

        return $this->export();
    }

    private function export()
    {
        return $this->model::all()->toJson();
    }

    private function validateKind()
    {
        if ($this->kind === 'tempmin') {
            $this->model = new MinTemperature;
        }

        if ($this->kind === 'tempmax') {
            $this->model = new MaxTemperature;
        }
    }
}
