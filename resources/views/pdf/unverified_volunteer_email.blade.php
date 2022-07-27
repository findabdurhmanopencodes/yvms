<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Unverified volunteer list</title>
    <style>
        table {
            padding: 0px;
            margin: 0pc;
            border: 1px solid black;

        }

        th {
            /* border-right: 1px solid black; */
            background: #eee;
            padding: 10px;
            margin: 0px;
        }

        td {
            padding: 10px;
            border-bootom: 1px solid black;
        }

    </style>
</head>

<body>
    <div style="max-width: 900px; margin: 0px auto;">
        <div style="text-align: center;">
            <img src="{{ public_path('/img/logo_peace.png') }}" alt="" style="width: 150px; height: 150px;">
        </div>
        <h1 style="margin-top:10px; color:#01afee;text-align:center; font-size:30px;">
            Ministry Of Peace
            <br>
            <span style="font-family:serif !important;">
                የሰላም ሚኒስቴር
            </span>
        </h1>
    </div>
    <hr>
    <div style="width: 100%;">
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Woreda</th>
                <th>Zone</th>
                <th>Region</th>
            </tr>
            @foreach ($volunteers as $volunteer)
                <tr>
                    <td>{{ $volunteer->name() }}</td>
                    <td>{{ $volunteer->email }}</td>
                    <td>{{ $volunteer->phone }}</td>
                    <td>{{ $volunteer->woreda->code ?? $volunteer->woreda->name }}</td>
                    <td>{{ $volunteer->woreda->zone->code ?? $volunteer->woreda->zone->name }}</td>
                    <td>{{ $volunteer->woreda->zone->region->code ?? $volunteer->woreda->zone->region->name }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</body>

</html>
