<?php

namespace App\Loaders;

use App\Models\MinTemperature;
use App\Models\MaxTemperature;

class Loader
{
    private $model, $samples, $kind, $year;

    private $data = [];

    public function init($samples, $kind, $year)
    {
        $this->samples = $samples;
        $this->kind = $kind;
        $this->year = $year;

        $this->validateKind();

        return $this->load();
    }

    public function load()
    {
        foreach ($this->samples as $sample) {
            $month = $sample[0];
            $value = $sample[1];

            $this->data['year'] = $this->year;
            $this->data[$month] = $value;
        }

        if (! $this->entryExists()) {
            return $this->model::create($this->getData());
        }

        return "{$this->data['year']} Entry Already Exists, Skipping ... \n";
    }

    private function getData()
    {
        return [
            'year' => $this->data['year'],
            'january' => $this->data['jan'],
            'february' => $this->data['fev'],
            'march' => $this->data['mar'],
            'april' => $this->data['abr'],
            'may' => $this->data['mai'],
            'june' => $this->data['jun'],
            'july' => $this->data['jul'],
            'august' => $this->data['ago'],
            'september' => $this->data['set'],
            'october' => $this->data['out'],
            'november' => $this->data['nov'],
            'december' => $this->data['dez'],
        ];
    }

    private function validateKind()
    {
        if ($this->kind == 'tempmin') {
            $this->model = new MinTemperature;
        }

        if ($this->kind == 'tempmax') {
            $this->model = new MaxTemperature;
        }
    }

    private function entryExists()
    {
        return $this->model::select("*")
            ->where('year', $this->data['year'])
            ->exists();
    }
}
