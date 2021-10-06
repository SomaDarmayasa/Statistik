<?php

namespace App\Exports;

use App\Models\Nilai as ModelsNilai;
use App\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromCollection,WithHeadings,WithMapping {

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ModelsNilai::all();
    }
    public function headings():array{
        return[
            'Skor'
        ];
    }

    public function map($nilai): array{
        return [
            $nilai->nilai,
        ];
    }

}


