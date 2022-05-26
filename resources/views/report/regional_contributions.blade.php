<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    <link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <style>
        @font-face {
            font-family: 'Ethiopian';
            src: url({{ storage_path('/fonts/amharic-jiret/jiret.ttf') }}) format('truetype'), url({{ storage_path('/fonts/amharic-jiret/jiret.woff') }}) format('woff');
        }

    </style>
</head>

<body>
    <div class="container bg-white rouded-lg" style="min-height:100vh">
        <div>
            <div class="row">
                <div style="text-align: center;display:inline;float: left;" class="col-sm-5">
                    <img src="img/logo_peace.png" alt="" style="width: 150px; height: 150px;">
                </div>
                <div class="col-sm-5" style="display:inline;">
                    <h1 style="margin-top:10px; color:#01afee;text-align:center; font-size:35px;">
                        Ministry Of Peace
                        <br>
                        <span style="font-size:40px; font-family: Ethiopian;">
                            የሰላም ሚኒስቴር
                        </span>
                    </h1>
                </div>
            </div>
            <hr />
        </div>
        <div class="row">
            <div class="col-8 m-auto">

                <table class="table table-bordered">
                    <thead>
                        <th>No</th>
                        <th>FGT</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        {{ dd($regionalQoutaAppliedPlaced) }}
                        @foreach ($regionalQoutaAppliedPlaced as $regional)
                            <tr>
                                {{-- {{ dd($regional) }} --}}
                                <td rowspan="3">ghdfs</td>
                                @foreach ($regional as $reg)
                                    <td>{{ $reg->y }}</td>
                                    <td>{{  $reg->x}}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

</body>

</html>
