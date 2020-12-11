<?php

namespace App\Extractors;

class Extractor
{
    private $path;

    public function __construct()
    {
        $this->path = env('UPLOADS_PATH');
    }

    public function extract($kind, $year, $monthNumber, $monthLabel)
    {
        $shortYear = substr($year, -2);

        $localFile = "{$year}-{$monthLabel}-{$kind}.gif";
        $cptecFile = "{$monthLabel}/{$kind}{$monthNumber}{$shortYear}.gif";

        $this->downloadFile($localFile, $cptecFile);

        return $localFile;
    }

    private function downloadFile($localFile, $cptecFile)
    {
        $url = "http://img0.cptec.inpe.br/~rclima/historicos/mensal/brasil/{$cptecFile}";

        return file_put_contents($this->path . $localFile, file_get_contents($url));
    }
}
