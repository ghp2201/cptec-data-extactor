<?php

namespace App\Http\Controllers;

use App\Exporters\Exporter;
use App\Jobs\DatabaseBuilder;

class Core extends Controller
{
    private $exporter;

    private $kinds = [
        'tempmin',
        'tempmax',
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->exporter = new Exporter;
    }

    public function extract($start, $end)
    {
        echo "Extracting Data And Building Database ... \n";

        foreach ($this->kinds as $kind) {
            dispatch(new DatabaseBuilder($kind, $start, $end));
        }

        return;
    }

    public function export($kind)
    {
        $json = $this->exporter->export($kind);

        if (empty(json_decode($json, true))) {
            echo "Empty Database, Please Perform an Extraction \n";

            return;
        }

        return $json;
    }
}
