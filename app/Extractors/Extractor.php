<?php

namespace App\Extractors;

class Extractor
{
    private $path, $filename, $year, $kind;

    private $months = [
        '01' => 'jan',
        '02' => 'fev',
        '03' => 'mar',
        '04' => 'abr',
        '05' => 'mai',
        '06' => 'jun',
        '07' => 'jul',
        '08' => 'ago',
        '09' => 'set',
        '10' => 'out',
        '11' => 'nov',
        '12' => 'dez',
    ];

    public function __construct()
    {
        $this->path = env('UPLOADS_PATH');
    }

    public function init($kind, $year)
    {
        $this->kind = $kind;
        $this->year = $year;

        return $this->extract();
    }

    private function extract()
    {
        $files = [];

        foreach ($this->months as $monthNumber => $monthLabel) {
            $this->download($monthLabel, $monthNumber);

            array_push($files, $this->filename);
        }

        return $files;
    }

    private function download($monthLabel, $monthNumber)
    {
        $this->filename = "{$this->year}-{$monthLabel}-{$this->kind}.gif";

        $url = $this->getUrl($monthLabel, $monthNumber);

        return file_put_contents($this->path . $this->filename, file_get_contents($url));
    }

    private function getUrl($monthLabel, $monthNumber)
    {
        $shortYear = substr($this->year, -2);

        $image = "{$monthLabel}/{$this->kind}{$monthNumber}{$shortYear}.gif";

        return "http://img0.cptec.inpe.br/~rclima/historicos/mensal/brasil/{$image}";
    }
}
