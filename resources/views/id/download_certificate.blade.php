<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&family=Noto+Serif+Ethiopic:wght@700&display=swap" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'Ethiopian';
            src: url({{ storage_path('fonts/jiret.ttf') }}) format('truetype'), url({{ storage_path('fonts/jiret.woff') }}) format('woff');
        }
        td{
            padding:5px;
        }

    </style>
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
                <p style="position: relative; left: 400px; top: 228px; background-color: inherit; font-size: 20px; color: rgb(158, 114, 10);">
                    <strong style="font-family: 'Noto Serif Ethiopic'">በ</strong>
                    <strong>{{ $training_session_id }}</strong>
                    <strong style="font-family: 'Noto Serif Ethiopic'">ኛ</strong>
                </p>
                <p style="position: relative; left: 690px; top: 194px; background-color: inherit; font-size: 20px; color: rgb(158, 114, 10);">
                    <strong>{{ $training_session_id }}</strong>
                </p>
                <p style="position: relative; left: 92px; top: 150px; background-color: inherit; font-size: 20px; color: rgb(158, 114, 10);">
                    <strong>{{ $diff_arr_string }}</strong>
                    <strong style="font-family: 'Noto Serif Ethiopic'">{{ $diff_arr_string_am }}</strong>
                </p>
                <p style="position: relative; left: 860px; top: 132px; background-color: inherit; font-size: 20px; color: rgb(158, 114, 10);">
                    <strong>{{ $diff_arr_string }} {{ $diff_arr_string_en }}</strong>
                </p>
                <p style="position: relative; left: 80px; top: 72px; background-color: inherit; font-size: 20px; color: rgb(158, 114, 10);">
                    <strong>10</strong>
                    <strong style="font-family: 'Noto Serif Ethiopic'">ወር</strong>
                </p>
                <p style="position: relative; left: 529px; top: 75px; background-color: inherit; font-size: 17px; color: rgb(158, 114, 10);">
                    <strong>12 mon</strong>
                </p>
                <p style="position: relative; left: 245px; top: 67px; background-color: inherit; font-size: 20px; color: rgb(158, 114, 10);">
                    <strong style="font-family: 'Noto Serif Ethiopic'">{{ $date_exp[0] }}</strong>
                    <strong>{{ $date_exp[1] }} {{ $date_exp[2] }}</strong>
                    <strong style="font-family: 'Noto Serif Ethiopic'">ዓ</strong>
                    <strong>.</strong>
                    <strong style="font-family: 'Noto Serif Ethiopic'">ም</strong>
                </p>
                <p style="position: relative; left: 770px; top: 35px; background-color: inherit; font-size: 24px; color: rgb(158, 114, 10);">
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
                <p style="position: relative; left: 180px; top: 422px; background-color: inherit; font-size: 20px; color: rgb(158, 114, 10);">
                    <strong style="font-family: 'Noto Serif Ethiopic'">{{ $date_exp[0] }}</strong>
                    <strong>{{ $date_exp[1] }} {{ $date_exp[2] }}</strong>
                </p>
                <p style="position: relative; left: 760px; top: 382px; background-color: inherit; font-size: 20px; color: rgb(158, 114, 10);">
                    <strong>{{ $currDatenow }}</strong>
                </p>
            </div>
        @endforeach
    @endif
</body>
</html>