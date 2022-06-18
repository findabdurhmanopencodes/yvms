<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if ($certifUsers == 'volunteers')
        @foreach ($html as $key=>$val)
            <div style="width: 1000px; height: 710px; background-size: cover; background-image: url('img/certificate_vol.png'); margin-right: 100px; break-after: page; margin-left: -40px; margin-top: -40px; page-break-after: always;">
                <p style="position: relative; left: 100px; top: 300px; background-color: inherit; font-size: 26px; color: rgb(158, 114, 10);">
                    <strong>{{ $val->first_name }} {{ $val->father_name }}</strong>
                </p>
                <p style="position: relative; left: 560px; top: 240px; background-color: inherit; font-size: 26px; color: rgb(158, 114, 10);">
                    <strong>{{ $val->first_name }} {{ $val->father_name }}</strong>
                </p>
                <p style="position: relative; left: 240px; top: 370px; background-color: inherit; font-size: 24px; color: rgb(158, 114, 10);">
                    <strong>{{ $currDateET }} ዓ.ም</strong>
                </p>
                <p style="position: relative; left: 770px; top: 335px; background-color: inherit; font-size: 24px; color: rgb(158, 114, 10);">
                    <strong>{{ $currDatenow }}</strong>
                </p>
            </div>
        @endforeach
    @else
        @foreach ($html as $key=>$val)
            <div style="width: 1000px; height: 710px; background-size: cover; background-image: url('img/certificate_app.png'); margin-right: 100px; break-after: page; margin-left: -40px; margin-top: -40px; page-break-after: always;">
                <p style="position: relative; left: 100px; top: 300px; background-color: inherit; font-size: 26px; color: rgb(158, 114, 10);">
                    <strong>{{ $val->user->first_name }} {{ $val->user->father_name }}</strong>
                </p>
                <p style="position: relative; left: 570px; top: 216px; background-color: inherit; font-size: 26px; color: rgb(158, 114, 10);">
                    <strong>{{ $val->user->first_name }} {{ $val->user->father_name }}</strong>
                </p>
                <p style="position: relative; left: 180px; top: 430px; background-color: inherit; font-size: 20px; color: rgb(158, 114, 10);">
                    <strong>{{ $currDateET }} </strong>
                </p>
                <p style="position: relative; left: 760px; top: 390px; background-color: inherit; font-size: 24px; color: rgb(158, 114, 10);">
                    <strong>{{ $currDatenow }}</strong>
                </p>
            </div>
        @endforeach
    @endif
</body>
</html>