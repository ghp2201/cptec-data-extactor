<?php

namespace App\Jobs;

use App\Extractors\Extractor;
use App\Samplers\Sampler;
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

    public function __construct(int $start, int $end)
    {
        $this->start = $start;
        $this->end = $end;

        $this->extractor = new Extractor;
        $this->sampler = new Sampler;
    }

    public function handle(): void
    {
        $kinds = [
            'tempmin',
            'tempmax',
        ];

        foreach ($kinds as $kind) {
            $this->build($kind);
        }
    }

    private function build(string $kind): void
    {
        $model = $this->setModelFromKind($kind);

        for ($year = $this->start; $year <= $this->end; $year++) {
            $files = $this->extractDataFromCptec($year, $kind);

            $samples = $this->sampler->sample($files, $year);

            $model::create([
                'year' => $year,
                'january' => $samples['jan'],
                'february' => $samples['fev'],
                'march' => $samples['mar'],
                'april' => $samples['abr'],
                'may' => $samples['mai'],
                'june' => $samples['jun'],
                'july' => $samples['jul'],
                'august' => $samples['ago'],
                'september' => $samples['set'],
                'october' => $samples['out'],
                'november' => $samples['nov'],
                'december' => $samples['dez'],
            ]);
        }
    }

    private function extractDataFromCptec(int $year, string $kind): array
    {
        $files = [];

        foreach ($this->months as $monthNumber => $monthLabel) {
            try {
                $files[$monthLabel] = $this->extractor->extract(
                    $kind,
                    $year,
                    $monthNumber,
                    $monthLabel
                );
            } catch (NotFoundHttpException $e) {
                $files[$monthLabel] = null;
            }
        }

        return $files;
    }

    private function setModelFromKind(string $kind): string
    {
        switch ($kind) {
            case 'tempmin':
                return MinTemperature::class;

            case 'tempmax':
                return MaxTemperature::class;

            default:
                throw new \Exception('Invalid kind ' . $kind, 1);
        }
    }
}
