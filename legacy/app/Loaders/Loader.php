<?php

namespace App\Loaders;

class Loader
{
    public function load($samples, $model, $year)
    {
        return $model::create([
            'year' => $year,
            'january' => $samples['jan'],
            'february' => $samples['fev'],
            'march' => $samples['mar'],
            'april' => $samples['abr'],
            'may' => $samples['mai'],
            'june' => $samples['jun'],
            'july' => $samples['jul'],
            'august' => $samples['ago'],
            'september' => $samples['set'],
            'october' => $samples['out'],
            'november' => $samples['nov'],
            'december' => $samples['dez'],
        ]);
    }
}
