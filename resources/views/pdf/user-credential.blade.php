<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Document</title>
    <style>
        .data{
            display:flex !important;
            justify-content: space-between;
        }
        .data-value{
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div style="max-width: 900px; margin: 0px auto;">
        <div style="text-align: center;">
            <img src="{{ public_path('img/logo_peace.png') }}" alt="" style="width: 150px; height: 150px;">
        </div>
        <h1 style="margin-top:10px; color:#01afee;text-align:center; font-size:26px;">
            Ministry Of Peace
            <br>
            <span style="font-family:serif !important;">
                {{mb_convert_encoding('የሰላም ሚኒስቴር', 'HTML-ENTITIES', 'UTF-8');}}
            </span>
        </h1>
        <hr>
        <div style="max-width: 400px;">
            <p class="data">
                <span class="date-title">
                    Full Name
                </span>
                <span class="data-value">
                    {{ $user->name() }}
                </span>
            </p>

            <p class="data">
                <span class="date-title">
                    Email
                </span>
                <span class="data-value">
                    {{ $user->email }}
                </span>
            </p>

            <p class="data">
                <span class="date-title">
                    Password
                </span>
                <span class="data-value">
                    {{ $password??'asldfj02s' }}
                </span>
            </p>

            <p class="data">
                <span class="date-title">
                    Print Date
                </span>
                <span class="data-value">
                    {{ $date }}
                </span>
            </p>
        </div>
    </div>

</body>
</html>
