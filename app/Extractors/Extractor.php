<?php

namespace App\Extractors;

class Extractor
{
    public function extract($kind, $year, $monthNumber, $monthLabel)
    {
        $shortYear = substr($year, -2);

        $filename = "{$kind}{$monthNumber}{$shortYear}.gif";

        $url = "http://img0.cptec.inpe.br/~rclima/historicos/mensal/brasil/{$monthLabel}/{$filename}";

        app('filesystem')->put("{$year}/{$filename}", file_get_contents($url));

        return $filename;
    }
}
