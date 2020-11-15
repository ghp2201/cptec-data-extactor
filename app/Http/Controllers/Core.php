<?php

namespace App\Http\Controllers;

use App\Extractors\Extractor;
use App\Samplers\Sampler;

class Core extends Controller
{
    public function init($kind)
    {
        $extractor = new Extractor;
        $sampler = new Sampler;

        $files = $extractor->extract($kind);
        $colors = $sampler->sample($files);
    }
}
