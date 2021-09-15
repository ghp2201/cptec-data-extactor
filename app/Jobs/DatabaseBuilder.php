<?php

namespace App\Jobs;

use App\Extractors\Extractor;
use App\Samplers\Sampler;
use App\Models\MinTemperature;
use App\Models\MaxTemperature;
use Illuminate\Database\Eloquent\Model;

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
        $model = $this->getModelFromKind($kind);

        for ($year = $this->start; $year <= $this->end; $year++) {
            $files = $this->extractDataFromCptec($year, $kind);

            $samples = $this->sampler->sample($files, $year);

            $dataset = [
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
            ];

            if ($this->entryDoesntExist($year, $model)) {
                $this->createEntry($model, $dataset);

                continue;
            }

            $this->updateEntry($model, $dataset, $year);
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

    private function getModelFromKind(string $kind): string
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

    private function entryDoesntExist(int $year, string $model): bool
    {
        return $model::where('year', $year)
            ->doesntExist();
    }

    private function createEntry(string $model, array $dataset): void
    {
        $model::create($dataset);
    }

    private function updateEntry(string $model, array $dataset, int $year): void
    {
        $entry = $model::where('year', $year)->first();

        $entry->fill($dataset);
        $entry->save();
    }
}
