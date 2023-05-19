<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class SKU
{
    public function make($source, $separator = '-')
    {
        $separator = $separator;
        $source = Str::studly($source);
        $source = Str::limit($source, 3, '');
        $signature = str_shuffle(str_repeat(str_pad('0123456789', 8, rand(0, 9) . rand(0, 9), STR_PAD_LEFT), 2));
        $signature = substr($signature, 0, 8);
        $result = implode($separator, [$source, $signature]);
        return Str::upper($result);
    }
}
