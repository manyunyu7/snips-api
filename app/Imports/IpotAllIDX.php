<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToCollection;

class IpotAllIDX implements ToArray
{
    public function array(array $rows)
    {
        return $rows;
    }
}
