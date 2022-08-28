
<!DOCTYPE html>

<html>

<head>

    <title> Trainee payroll </title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>


table {
    border-collapse: collapse;
}

    </style>


<script src="{{ asset('assets/js/pages/crud/ktdatatable/base/data-ajax.js') }}"></script>

</head>

<body>
    <div style="text-align: center;">
        <img src="{{ public_path('img/logo_peace.png') }}" alt="" style="width: 100px; height: 100px;">
    </div>
    <h1 style="margin-top:10px; color:#01afee;text-align:center; font-size:20px;">
        <span style="text-align:center;">
            <p style="font-size: 19px"> <b>  Ministery of Peace </b> </p>
            <p style="font-size: 14px"><b>   Youth Volunterism Managment System </b></p>
            <p style="font-size: 12px"><b>   Volunter Monthly Payroll</b></p>

        </span>

    </h1>
    <hr>


     <table width="100%" style="font-size: 15px" class="table table-striped">
        <thead>
            <tr style="background-color:lightblue;">
            <th style="text-align:left; width:3%"> #</th>
            <th style="text-align:left;width:20%;"> Name </th>
            <th style="text-align:left;"> Phone </th>
            <th style="text-align:left;width:5%;"> Sex </th>
            <th style="text-align:left;"> Woreda </th>
            <th style="text-align:left;"> CBE Account </th>
            <th style="text-align:left; width:15%"> Month  </th>
            <th style="text-align:left;"> Attended Days </th>
            <th style="text-align:right;"> Amount </th>



            </tr>
        </thead>
        <tbody>

            @foreach ($att_counts as $key => $att_count)
                <tr>
                     <td>{{ $key + 1 }}</td>
                      <td>  {{ $att_counts->first_name}} {{ $att_count->father_name}}  {{$att_count->grand_father_name}}  </td>
                     <td> {{  $att_count->phone }} </td>
                     <td> {{  $att_count->gender }} </td>
                     <td>  {{ $att_count->woreda->name }}  </td>
                     <td> {{  $att_count->account_number }} </td>
                     <td>  {{ $sdate ->format("m/d/Y")}} - {{$edate->format("m/d/Y")}} </td>

                     <td> {{  $day }}  </td>

                     <td style="text-align:right;">   Birr {{ number_format($fixedAmount->amount,2)}}</td>


                </tr>

            @endforeach
            <tr style="text-align:right;">
                <td colspan="8">
                    <?php $sum = 0 ?>
                    @foreach ($att_counts as $key => $att_count)

                    <?php $sum =  $sum + $fixedAmount->amount; ?>




                    @endforeach
              Total:     <span style="border-bottom: 3px double;"> ETB  {{  number_format($sum,2)  }} </span>
                </td>
                <td colspan="1"></td>
            </tr>
        </tbody>
    </table>

    <hr>
    <div class="float-right">   Total payee: <u>20 </u> </div> <br>

    {{-- {{ $total_volunteers }} --}}

    <p style="text-align:right;">
    _____________________<br>
    <span >  {{ Auth::user()->first_name }}  {{ Auth::user()->father_name }}</span><br>

    {{ date( 'l, F Y') }}
    </p>
</body>

</html>

