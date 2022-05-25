<?php

namespace App\Exports;

use App\Models\UserAttendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $a;

    public function __construct($data, $a)
    {
        $this->data = $data;
        $this->a = $a;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return $this->a;
    }
}
