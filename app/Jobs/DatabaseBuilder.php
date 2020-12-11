<?php

namespace App\Jobs;

use App\Extractors\Extractor;
use App\Samplers\Sampler;
use App\Loaders\Loader;
use App\Models\MinTemperature;
use App\Models\MaxTemperature;

class DatabaseBuilder extends Job
{
    private $kind, $start, $end, $model, $extractor, $sampler, $loader;

    private $months = [
        '01' => 'jan',
        '02' => 'fev',
        '03' => 'mar',
        '04' => 'abr',
        '05' => 'mai',
        '06' => 'jun',
        '07' => 'jul',
        '08' => 'ago',
        '09' => 'set',
        '10' => 'out',
        '11' => 'nov',
        '12' => 'dez',
    ];

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
        $this->setModelFromKind($this->kind);

        for ($year = $this->start; $year <= $this->end; $year++) {
            $files = [];

            if ($this->entryDoesntExist($year)) {
                foreach ($this->months as $monthNumber => $monthLabel) {
                    try {
                        $files[$monthLabel] = $this->extractor->extract(
                            $this->kind,
                            $year,
                            $monthNumber,
                            $monthLabel
                        );
                    } catch (NotFoundHttpException $e) {
                        $files[$monthLabel] = null;
                    }
                }

                $samples = $this->sampler->sample($files, $year);

                $this->loader->load($samples, $this->model, $year);
            }
        }
    }

    private function setModelFromKind($kind)
    {
        if ($kind == 'tempmin') {
            $this->model = new MinTemperature;
        } else if ($kind == 'tempmax') {
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
