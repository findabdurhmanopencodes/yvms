<?php

namespace App\Exports;

use App\Models\Applicants;
use App\Models\Volunteer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class ApplicantExport implements FromCollection, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $woredas;
    protected $data;
    protected $a;


   public function __construct($woredas, $data, $a)
   {
    // dd($woredas);
       $this->woredas = $woredas;
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

                $drop_column = 'F';
                $drop_column_woredas = 'G';

                $options = [
                    'Male',
                    'Female',
                ];

                $optionworedas = $this->woredas->toArray();
                $column_count = count($optionworedas) + 1;
                
                $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST );
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION );
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Input error');
                $validation->setError('Value is not in list.');
                $validation->setPromptTitle('Pick from list');
                $validation->setPrompt('Please pick a value from the drop-down list.');
                $validation->setFormula1(sprintf('"%s"',implode(',',$options)));

                $validation2 = $event->sheet->getCell("{$drop_column_woredas}2")->getDataValidation();
                $validation2->setType(DataValidation::TYPE_LIST );
                $validation2->setErrorStyle(DataValidation::STYLE_INFORMATION );
                $validation2->setAllowBlank(false);
                $validation2->setShowInputMessage(false);
                $validation2->setShowErrorMessage(false);
                $validation2->setShowDropDown(true);
                $validation2->setErrorTitle('Input error');
                $validation2->setError('Value is not in list.');
                $validation2->setPromptTitle('Pick from list');
                $validation2->setPrompt('Please pick a value from the drop-down list.');
                $validation2->setFormula1(sprintf("'%s'",implode(',',$optionworedas)));

                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(30);

                for ($i = 3; $i <= 50000; $i++) {
                    $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    $event->sheet->getCell("{$drop_column_woredas}{$i}")->setDataValidation(clone $validation2);
                }
           },
       ];
   }
}