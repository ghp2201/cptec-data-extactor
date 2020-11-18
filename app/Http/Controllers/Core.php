<?php

namespace App\Http\Controllers;

use App\Extractors\Extractor;
use App\Samplers\Sampler;
use App\Loaders\Loader;
use App\Exporters\Exporter;

class Core extends Controller
{
    private $extractor, $sampler, $loader, $exporter;

    public function __construct()
    {
        $this->extractor = new Extractor;
        $this->sampler = new Sampler;
        $this->loader = new Loader;
        $this->exporter = new Exporter;
    }

    public function extract($kind, $initialExtractionYear, $finalExtractionYear)
    {
        for ($i = $initialExtractionYear; $i <= $finalExtractionYear; $i++) {
            $files = $this->extractor->init($kind, $i);
            $samples = $this->sampler->init($files);

            $this->loader->init($samples, $kind, $i);
        }
    }

    public function export($kind)
    {
        $json = $this->exporter->init($kind);

        if (empty(json_decode($json, true))) {
            echo "Empty Database, Please Perform an Extraction";
            return;
        }

        return $json;
    }
}
