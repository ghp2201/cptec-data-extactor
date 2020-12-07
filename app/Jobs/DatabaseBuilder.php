<?php

namespace App\Jobs;

use App\Extractors\Extractor;
use App\Samplers\Sampler;
use App\Loaders\Loader;
use App\Models\MinTemperature;
use App\Models\MaxTemperature;

class DatabaseBuilder extends Job
{
    private $kind, $start, $end, $model;

    private $extractor, $sampler, $loader;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($kind, $start, $end)
    {
        $this->kind = $kind;
        $this->start = $start;
        $this->end = $end;

        $this->extractor = new Extractor;
        $this->sampler = new Sampler;
        $this->loader = new Loader;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->validateKind();

        for ($year = $this->start; $year <= $this->end; $year++) {
            if ($this->entryDoesntExist($year)) {
                $files = $this->extractor->init($this->kind, $year);
                $samples = $this->sampler->init($files, $year);

                $this->loader->init($samples, $this->model, $year);
            }
        }
    }

    private function validateKind()
    {
        if ($this->kind == 'tempmin') {
            $this->model = new MinTemperature;
        }

        if ($this->kind == 'tempmax') {
            $this->model = new MaxTemperature;
        }
    }

    private function entryDoesntExist($year)
    {
        return $this->model::select("*")
            ->where('year', $year)
            ->doesntExist();
    }
}
