<?php

namespace App\Http\Controllers;

class Extractor extends Controller
{
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

    public function index()
    {
        $this->downloadImages('tempmin');
        $this->downloadImages('tempmax');
    }

    private function downloadImages($kind)
    {
        $firstYear = env('INITIAL_EXTRACTION_YEAR');
        $lastYear = env('FINAL_EXTRACTION_YEAR');

        for ($year = $firstYear; $year <= $lastYear; $year++) {
            foreach ($this->months as $key => $month) {
                $file = 'uploads/' . $year . '-' . $month . '-' . $kind . '.gif';

                $url = $this->getCptecUrl($month, $key, $kind, $year);

                if (file_exists($file)) {
                    echo $file . ' Already Exists, Skiping ...';
                    continue;
                }

                file_put_contents($file, file_get_contents($url));
            }
        }
    }

    private function getCptecUrl($monthLabel, $monthNumber , $kind, $year)
    {
        $shortYear = substr($year, -2);

        $default = 'http://img0.cptec.inpe.br/~rclima/historicos/mensal/brasil/';
        $image = $monthLabel . '/' . $kind . $monthNumber. $shortYear . '.gif';

        return $default . $image;
    }
}
