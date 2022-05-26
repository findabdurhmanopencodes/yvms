
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

</head>

<body>
    <div style="text-align: center;">
        <img src="{{ public_path('img/logo_peace.png') }}" alt="" style="width: 100px; height: 100px;">
    </div>
    <h1 style="margin-top:10px; color:#01afee;text-align:center; font-size:20px;">
        <span style="text-align:center;">
            <p style="font-size: 19px"> <b>  Ministery of Peace </b> </p>
            <p style="font-size: 14px"><b>  Youth Volunterism Managment System </b></p>
            <p style="font-size: 12px"><b>   Trainee payroll Sheet</b></p>

        </span>

    </h1>
    <hr>


     <table width="100%" style="font-size: 14px" class="table table-striped" border="1">
        <thead>
            <tr style="background-color:lightblue;">
            <th style="text-align:left; width:3%"> #</th>
            <th style="text-align:left;"> Name </th>
            <th style="text-align:left;"> Phone </th>
            <th style="text-align:left;"> Sex </th>
            <th style="text-align:left;"> Zone </th>
            <th style="text-align:left;"> CBE Acc </th>
            <th style="text-align:left;"> Amount </th>
            <th style="text-align:left; width:10%"> Sign</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($placedVolunteers as $key => $placedVolunteer)
                <tr>
                     <td>{{ $key + 1 }}</td>
                      <td>  {{ $placedVolunteer->first_name}} {{ $placedVolunteer->father_name}}  {{ $placedVolunteer->grand_father_name}}  </td>
                     <td> {{ $placedVolunteer->phone }} </td>
                     <td> {{ $placedVolunteer->gender }} </td>
                     <td>  {{ $placedVolunteer->woreda->zone->name }}  </td>
                     <td> 1000259685471 </td>
                     <td style="text-align:right;"> 785.00 </td>


                     <td>  &nbsp; &nbsp; &nbsp; </td>


                </tr>

            @endforeach
            <tr style="text-align:right;">
                <td colspan="7">Grand total: ETB 785.00 </td>
                <td colspan="1"></td>
            </tr>
        </tbody>
    </table>
    <div class="float-right"> Session :01  Training center :Jimma University   Total Amount: 15,656    Total payee:122 </div> <br>



    <p style="text-align:right;">
    _____________________<br>
    <span >  {{ Auth::user()->first_name }}  {{ Auth::user()->father_name }}</span>
    </p>
</body>

</html>
