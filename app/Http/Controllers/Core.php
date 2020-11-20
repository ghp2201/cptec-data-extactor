<?php

namespace App\Http\Controllers;

use App\Exporters\Exporter;
use App\Jobs\DatabaseBuilder;

class Core extends Controller
{
    private $exporter;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->exporter = new Exporter;
    }

    public function extract($kind, $start, $end)
    {
        echo "Extracting Data And Building Database ... \n";

        $job = new DatabaseBuilder($kind, $start, $end);

        dispatch($job);

        return;
    }

    public function export($kind)
    {
        $json = $this->exporter->init($kind);

        if (empty(json_decode($json, true))) {
            echo "Empty Database, Please Perform an Extraction \n";
            return;
        }

        return $json;
    }
}
