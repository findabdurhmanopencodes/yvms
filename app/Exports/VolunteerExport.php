<?php

namespace App\Exports;

use App\Models\Volunteer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class VolunteerExport implements FromCollection ,WithHeadings
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
}
