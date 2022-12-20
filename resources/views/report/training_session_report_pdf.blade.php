
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
            <p style="font-size: 30px"> <b>  Ministery of Peace </b> </p>
            <p style="font-size: 25px"><b>   Youth Volunterism Managment System </b></p>
            <p style="font-size: 20px"><b>   Training session Report [ ] </b></p>

        </span>

    </h1>
    <hr>

     <table width="100%" style="font-size: 15px" class="table table-striped">
        <tbody>


            <br>
            <tr>
                <th style="text-align: left;">I. Voluneteer Application Repprt : </th>
            </tr>  <br><hr>

            <tr>



                <th style="text-align:right;">Total Vouleneters :</th>
                <th><u>7,991 </u> </th>
                <th> Male:</th>
                <td> <u> 5,000 </u></td>
                <th> Female:</th>
                <td><u>2,991 </u> </td>
              </tr>
              <br>
            <?php $i =0; ?>
              @foreach ($regions  as $region)

            <tr>
                <th style="text-align:left;">{{ ++$i }} &nbsp;
                {{$region->name   }}:</th>

                  <th> Quata: {{ number_format($region->qoutaInpercent*100 ,1,'.',',')  }} %
                    </th>
                    <th> Male:</th>
                    <td> <u>4,000 </u></td>
                    <th> Female:</th>
                    <td> <u>2,991 </u></td>
            </tr>
            @endforeach
            <div class="page_break"></div>

            <br>    <br>    <br>


            <tr>
                <th style="text-align: left;"> II. Selected Voluneteers for placement : </th>

            </tr> <br><hr>
            <tr>

                <th style="text-align:right;">Total Vouleneters :</th>
                <th> <u>9,917 </u> </th>
                <th>  Male:</th>
                <td> <u> 6,700</u></td>
                <th> <u> Female:</u></th>
                <td> <u>1,291 </u> </td>
            </tr><br>
              <br>


         <?php $i =0; ?>
              @foreach ($training_centers  as $training_center)


            <tr>
                <th style="text-align:left;">{{ ++$i }} &nbsp;
                 {{$training_center->name   }}: </th>
                <th> Intake capacity: <u> {{ '2,000'}} </u></th>
                <th>Male:</th>
                <td> <u> 5,855</u></td>
                <th>Female:</th>
                <td> <u>2,855 </u></td>

            </tr> <br>
            @endforeach




            <tr>
                <th style="text-align: left;"> III. Voluneteers Deployement report: </th>

            </tr> <br><hr>
            <tr>

                <th style="text-align:right;">Total deployed :</th>
                <th> <u>9,917 </u> </th>
                <th>  Male:</th>
                <td> <u> 6,700</u></td>
                <th> <u> Female:</u></th>
                <td> <u>1,291 </u> </td>
            </tr><br>
              <br>

            <?php $i =0; ?>
            @foreach ($regions  as $region)

          <tr>
              <th style="text-align:left;">{{ ++$i }} &nbsp;
              {{$region->name   }}:</th>

                <th>  Total deployed: {{ number_format($region->qoutaInpercent*100 ,1,'.',',')  }} %
                  </th>
                  <th> Male:</th>
                  <td> <u>4,000 </u></td>
                  <th> Female:</th>
                  <td> <u>2,991 </u></td>
          </tr>
          @endforeach
          <div class="page_break"></div>

          <br>    <br>    <br>

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

