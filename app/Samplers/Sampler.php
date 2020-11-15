<?php

namespace App\Samplers;

class Sampler
{
    private $image, $x, $y;

    private $colorTemperatureRelation = [
        'rgb(130, 0, 220)' => 5,
        'rgb(0, 0, 130)' => 7,
        'rgb(0, 0, 200)' => 9,
        'rgb(30, 110, 245)' => 11,
        'rgb(60, 150, 245)' => 13,
        'rgb(120, 185, 250)' => 15,
        'rgb(150, 210, 250)' => 17,
        'rgb(40, 130, 240)' => 17,
        'rgb(180, 240, 250)' => 19,
        'rgb(120, 185, 250)' => 19,
        'rgb(225, 255, 255)' => 21,
        'rgb(180, 240, 250)' => 21,
        'rgb(255, 255, 200)' => 23,
        'rgb(255, 250, 130)' => 25,
        'rgb(219, 178, 38)' => 27,
        'rgb(189, 118, 0)' => 29,
        'rgb(165, 70, 0)' => 31,
        'rgb(147, 34, 0)' => 33,
        'rgb(105, 0, 0)' => 35,
        'rgb(40, 0, 0)' => 37,
    ];

    public function sample($files)
    {
        $values = [];

        foreach ($files as $file) {
            $this->image = imagecreatefromgif($file);
            $this->validateImage();

            $value = $this->getValueFromColor();

            array_push($values, $value);
        }

        return $values;
    }

    private function getValueFromColor()
    {
        $pixelColor = imagecolorat($this->image, $this->x, $this->y);
        $colors = imagecolorsforindex($this->image, $pixelColor);

        $color = "rgb({$colors['red']}, {$colors['green']}, {$colors['blue']})";

        return $this->colorTemperatureRelation[$color];
    }

    private function validateImage()
    {
        $width = imagesx($this->image);
        $height = imagesy($this->image);

        if ($width == 430 && $height == 543) {
            $this->x = 262;
            $this->y = 374;
        }

        if ($width == 430 && $height == 545) {
            $this->x = 262;
            $this->y = 376;
        }

        if ($width == 500 && $height == 647) {
            $this->x = 316;
            $this->y = 435;
        }
    }
}
