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

    /**
     * Dispatch the jobs for extracting maximum and minimum temperature data from
     * CPTEC heatmaps
    */
    public function extract(string $start, string $end)
    {
        dispatch(new DatabaseBuilder($start, $end, null));

        return response()->json([
            'message' => "Job dispatched to consume data from " . $start . " to " . $end,
        ], 200);
    }

    /**
     * Dispatch the jobs for extracting temperature data from CPTEC heatmaps with
     * a specific kind
    */
    public function extractWithKind(string $start, string $end, string $kind)
    {
        dispatch(new DatabaseBuilder($start, $end, [$kind]));

        return response()->json([
            'message' => "Job dispatched to consume data from " . $start . " to " . $end . " with kind " . $kind,
        ], 200);
    }

    /**
     * Exports all available info for all kinds as a JSON array
    */
    public function export()
    {
        $json = [];

        foreach ($this->kinds as $kind) {
            $json[$kind] = $this->exporter->export($kind);
        }

        if (empty($json)) {
            return response()->json([
                'message' => "Empty database, please perform an extraction",
            ], 500);
        }

        return response()->json($json, 200);
    }

    /**
     * Exports all available info for a specific kind as a JSON object
    */
    public function exportWithKind(string $kind)
    {
        $json = $this->exporter->export($kind);

        if (empty($json)) {
            return response()->json([
                'message' => "Empty database, please perform an extraction",
            ], 500);
        }

        return response()->json($json, 200);
    }
}
