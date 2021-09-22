<?php

namespace App\Helpers;

use App\Models\MinTemperature;
use App\Models\MaxTemperature;

class Model
{
    public static function getModelClassNameFromKind(string $kind): string
    {
        switch ($kind) {
            case 'tempmin':
                return MinTemperature::class;

            case 'tempmax':
                return MaxTemperature::class;
        }
    }
}
