
<!DOCTYPE html>

<html>

<head>

    <title>  Deployment  payroll </title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>


table {
    border-collapse: collapse;
}

    </style>

</head>

<body>
    <div style="text-align: center;">
        <img src="{{ public_path('img/logo_peace.png') }}" alt="" style="width: 100px; height: 100px;">
    </div>
    <h1 style="margin-top:10px; color:#01afee;text-align:center; font-size:20px;">
        <span style="text-align:center;">
            <p style="font-size: 19px"> <b>  Ministery of Peace </b> </p>
            <p style="font-size: 14px"><b>   Youth Volunterism Managment System </b></p>
            <p style="font-size: 12px"><b>   Trainee Deployment payroll Sheet</b></p>

        </span>

    </h1>
    <hr>


     <table width="100%" style="font-size: 15px" class="table table-striped">
        <thead>
            <tr style="background-color:lightblue;">
            <th style="text-align:left; width:3%"> #</th>
            <th style="text-align:left; width:20%;"> Name </th>
            <th style="text-align:left;"> Phone </th>
            <th style="text-align:left; width:5%;"> Sex </th>
            <th style="text-align:left;"> Destination </th>
            <th style="text-align:left;width:16%;"> CBE Account </th>
            <th style="text-align:left; width:15%"> Date range  </th>
            <th style="text-align:left;"> KM </th>
            <th style="text-align:left;"> Tarif </th>
            <th style="text-align:right;"> Amount </th>
            <th style="text-align:left; width:10%">Remark</th>
            </tr>
        </thead>
        <tbody>
              @foreach ($placedVolunteers as $key => $placedVolunteer)
                <tr>
                     <td> {{ $key + 1 }}</td>
                     <td> {{ $placedVolunteer->first_name}} {{ $placedVolunteer->father_name}}  {{ $placedVolunteer->grand_father_name}}  </td>
                     <td> {{ $placedVolunteer->phone }} </td>
                     <td> {{ $placedVolunteer->gender }} </td>
                     <td> {{ $placedVolunteer->woreda->zone->name }}  </td>
                     <td> {{ $placedVolunteer->account_number }} </td>
                     <td>  {{ $sdate ->format("d/m/Y") }} - {{  Carbon\Carbon::parse($sdate)->addDays(round($day) )->format('d-m-Y') }}</td>
                     <td> {{  $kms[$key]?? '0'   }} </td>
                     <td> {{  $tarif }} </td>
                     <td style="text-align:right;"> {{ number_format( $kms[$key]* $tarif ,2 ?? '-')}}</td>
                     <td>  &nbsp;  &nbsp; &nbsp; &nbsp;   - </td>
                </tr>


            @endforeach
            <tr style="text-align:right;">
                <td colspan="8">
                    <?php $sum = 0 ?>
                    @foreach ($placedVolunteers as $key => $placedVolunteer)
                    <?php $sum =  $sum + $totals[$key]; ?>
                    @endforeach
                      Total:    <span style="border-bottom: 3px  double;">  Birr {{  number_format($sum,2)}}</span>
                </td>
                <td colspan="1"></td>
            </tr>
        </tbody>
    </table>
    <hr>

    <div class="float-right"> Training center :<u> ___________________  </u>  Total payee: <u>{{ $total_volunteers }} </u> </div> <br>



    <p style="text-align:right;">
    _____________________<br>
    <span >  {{ Auth::user()->first_name }}  {{ Auth::user()->father_name }}</span> <br>
    {{ date( 'l, F Y') }}


    </p>
</body>

</html>

