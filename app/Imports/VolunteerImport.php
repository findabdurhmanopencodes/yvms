<?php

namespace App\Imports;

use App\Models\Volunteer;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStartRow;


class VolunteerImport implements ToCollection ,WithStartRow
{

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
            // dd($row);

    //     foreach ($rows as $row)
    //     {
    //         return new Volunteer([
    //                 ::updateOrCreate(
    //             [
    //                 'color' => $row[0],
    //                 'taste' => $row[1],
    //                 'smell' => $row[2],
    //                 'name' => $row[3]
    //             ],
    //             [
    //                 'price' => $row[4],
    //                 'supplier_id' => $row[5],
    //                 ...
    //             ]
    //         );
    //     }
    //     return new Volunteer([
    //         //
    //     ]);
    // }
    }
    public function collection(Collection $rows)
    {
        // dd($rows);
        foreach ($rows as $row)
        {

           $volunteer= Volunteer::where(['id_number'=>$row[0]])->first();
               $volunteer->account_number=$row[4];
               $volunteer->save();
        }

    }

    public function startRow(): int
    {
        return 2;
    }
}
