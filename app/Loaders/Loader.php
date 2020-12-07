<?php

namespace App\Loaders;

use App\Models\MinTemperature;
use App\Models\MaxTemperature;

class Loader
{
    private $model, $samples, $year;

    private $data = [];

    public function init($samples, $model, $year)
    {
        $this->samples = $samples;
        $this->model = $model;
        $this->year = $year;

        return $this->load();
    }

    public function load()
    {
        foreach ($this->samples as $sample) {
            $month = $sample[0];
            $value = $sample[1];

            $this->data[$month] = $value;
        }

        return $this->model::create($this->getData());
    }

    private function getData()
    {
        return [
            'year' => $this->year,
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
}
