<?php

namespace App\Imports;

// use App\Models\Nilai as ModelsNilai;
use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\WithHeadingRow as ConcernsWithHeadingRow;

class StudentsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Nilai([
            'nilai' => $row[1],
        ]);
    }
}
