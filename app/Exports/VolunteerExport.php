<?php

namespace App\Exports;

use App\Models\Volunteer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class VolunteerExport implements FromCollection ,WithHeadings,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
   protected $data;
   protected $a;


   public function __construct($data, $a)
   {
    // dd($a);
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
   public function registerEvents(): array
   {
       return [
           AfterSheet::class => function(AfterSheet $event) {

               $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(35);
               $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(35);
               $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(35);

           },
       ];
   }
}
