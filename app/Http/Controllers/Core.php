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

    public function extract(string $start, string $end)
    {
        echo "Extracting data from " . $start . " to " . $end . " ... \n";

        dispatch(new DatabaseBuilder($start, $end, null));

        return;
    }

    public function extract_with_kind(string $start, string $end, string $kind): void
    {
        echo "Extracting data from " . $start . " to " . $end . " with kind " . $kind . " ... \n";

        dispatch(new DatabaseBuilder($start, $end, $kind));

        return;
    }

    public function export($kind): void|string
    {
        $json = $this->exporter->export($kind);

        if (empty(json_decode($json, true))) {
            echo "Empty Database, Please Perform an Extraction \n";

            return;
        }

        return $json;
    }
}
