
<!DOCTYPE html>

<html>

<head>

    <title> Transportation payroll </title>

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
    <h1 style="margin-top:10px; color:#01afee;text-align:center; font-size:25px;">
        <span style="text-align:center;">
            <p style="font-size: 19px"> <b>  Ministery of Peace </b> </p>
            <p style="font-size: 14px"><b>   Youth Volunterism Managment System </b></p>
            <p style="font-size: 12px"><b>   Training session Report </b></p>

        </span>

    </h1>
    <hr>

     <table width="100%" style="font-size: 15px" class="table table-striped">
        <tbody>


            <br>
            <tr>
                <th><u></u> 1. Voluneteer Application Repprt : </u></th>

            </tr>

            <tr>

                <th>Total Vouleneters :</th>

                <th>Male:</th>
                <td>  7,855</td>
                <th>Female:</th>
                <td>  7,855</td>
              </tr>
              <br>


    <?php $i =0; ?>
              @foreach ($regions  as $region)


            <tr>
                <th style="text-align:left;">{{ ++$i }} &nbsp;
                {{$region->name   }}:</th>

                <th> Quatat: {{ number_format($region->qoutaInpercent*100 ,1,'.',',')  }} %


                    </th>

                <th>Male:</th>

                <td>  7,855</td>
                <th>Female:</th>
                <td> 7,855</td>

            </tr>
            @endforeach
            <div class="page_break"></div>

            <br>    <br>    <br>


            <tr>
                <th><u></u> 2.Selected Voluneteers for placement : </u></th>

            </tr>


            <tr>

                <th>Total Vouleneters :</th>
                <td> 7,855</td></td>
                <th>Male:</th>
                <td>  7,855</td></td>
                <th>Female:</th>
                <td>  7,855</td></td>
            </tr><br>




              <br>


    <?php $i =0; ?>
              @foreach ($training_centers  as $training_center)


            <tr>
                <th style="text-align:left;">{{ ++$i }} &nbsp;
                {{$training_center->name   }}:</th>

                <th> Intake capacity: {{ '0'}} </th>

                <th>Male:</th>
                <td>  7,855</td>
                <th>Female:</th>
                <td> 7,855</td>

            </tr>
            @endforeach
            <br>

        </tbody>
    </table>
    <hr>


    <p style="text-align:right;">
    _____________________<br>
    <span >  {{ Auth::user()->first_name }}  {{ Auth::user()->father_name }}</span> <br>
    {{ date( 'l, F Y') }}


    </p>
</body>

</html>

