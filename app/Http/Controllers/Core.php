<?php

namespace App\Http\Controllers;

use App\Extractors\Extractor;
use App\Samplers\Sampler;
use App\Loaders\Loader;

class Core extends Controller
{
    private $firstYear, $lastYear;

    public function __construct()
    {
        $this->firstYear = env('INITIAL_EXTRACTION_YEAR');
        $this->lastYear = env('FINAL_EXTRACTION_YEAR');
    }

    public function init($kind)
    {
        $extractor = new Extractor();
        $sampler = new Sampler;
        $loader = new Loader;

        for ($i = $this->firstYear; $i <= $this->lastYear; $i++) {
            $files = $extractor->init($kind, $i);
            $samples = $sampler->init($files);

            $loader->init($samples, $kind, $i);
        }
    }
}
