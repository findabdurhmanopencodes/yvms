<?php

namespace App\Exports;

use App\Models\DeploymentVolunteerAttendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class DeploymentAttendanceReportExport implements FromCollection, WithHeadings, WithEvents
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
        // dd($this->data);
        return collect($this->data);
    }
    public function headings(): array
    {
        return $this->a;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(20);

                $event->sheet->getProtection()->setPassword('password');
                $event->sheet->getProtection()->setSheet(true);
                $event->sheet->getStyle('G1:G'.count($this->data) + 1)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                // $event->sheet->getStyle('F2')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
            },
            
        ];
    }
}
