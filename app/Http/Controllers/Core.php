<?php

namespace App\Http\Controllers;

use App\Extractors\Extractor;
use App\Samplers\Sampler;
use App\Loaders\Loader;
use App\Exporters\Exporter;

class Core extends Controller
{
    private $firstYear, $lastYear, $extractor, $sampler, $loader, $exporter;

    public function __construct()
    {
        $this->firstYear = env('INITIAL_EXTRACTION_YEAR');
        $this->lastYear = env('FINAL_EXTRACTION_YEAR');

        $this->extractor = new Extractor;
        $this->sampler = new Sampler;
        $this->loader = new Loader;
        $this->exporter = new Exporter;
    }

    public function extract($kind)
    {
        for ($i = $this->firstYear; $i <= $this->lastYear; $i++) {
            $files = $this->extractor->init($kind, $i);
            $samples = $this->sampler->init($files);

            $this->loader->init($samples, $kind, $i);
        }
    }

    public function export($kind)
    {
        $json = $this->exporter->init($kind);

        if (empty(json_decode($json, true))) {
            $this->extract($kind);

            return $this->export($kind);
        }

        return $json;
    }
}
