<?php

namespace App\Exporters;

use App\Helpers\Model as ModelHelper;

class Exporter
{
    public function export($kind): array
    {
        $model = ModelHelper::getModelClassNameFromKind($kind);

        return $model::orderBy('year', 'asc')->get()->toArray();
    }
}
