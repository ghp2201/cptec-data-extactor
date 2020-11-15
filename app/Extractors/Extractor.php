<?php

namespace App\Extractors;

class Extractor
{
    private $file, $firstYear, $lastYear, $kind;

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
        $this->firstYear = env('INITIAL_EXTRACTION_YEAR');
        $this->lastYear = env('FINAL_EXTRACTION_YEAR');
    }

    public function extract($kind)
    {
        $extractedFiles = [];

        for ($i = $this->firstYear; $i <= $this->lastYear; $i++) {
            foreach ($this->months as $monthNumber => $monthLabel) {
                $this->download($monthLabel, $monthNumber, $kind, $i);

                array_push($extractedFiles, $this->file);
            }
        }

        return $extractedFiles;
    }

    private function download($monthLabel, $monthNumber , $kind, $year)
    {
        $this->file = "uploads/{$year}-{$monthLabel}-{$kind}.gif";

        $this->validateFile();

        $url = $this->getUrl($monthLabel, $monthNumber , $kind, $year);

        file_put_contents($this->file, file_get_contents($url));

        return $this->file;
    }

    private function getUrl($monthLabel, $monthNumber , $kind, $year)
    {
        $shortYear = substr($year, -2);

        $defaultUrl = "http://img0.cptec.inpe.br/~rclima/historicos/mensal/brasil/";
        $file = "{$monthLabel}/{$kind}{$monthNumber}{$shortYear}.gif";

        return $defaultUrl . $file;
    }

    private function validateFile()
    {
        if (file_exists($this->file)) {
            echo "{$this->file} Already Exists, Skiping ... \n";

            return $this->file;
        }
    }
}
