<!DOCTYPE html>
<html lang="en">

<head>
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

<body style="font-family: 'EB Garamond', serif;">
    <div>
            <table style="border-collapse: collapse;width: 100%;margin:0px;">
        <tbody>
            <tr>
                <td>
                    <div class="">
                        <img src="img/logo_peace.png" alt="" style="width: 150px; height: 150px;">
                    </div>
                </td>
                <td style="text-align: center;color:#01afee;">
                    <div>
                        <h1>
                           <span style="font-family: 'EB Garamond', serif;, serif;font-size:54px;"> Ministry Of Peace</span>
                           <br/>
                            <span style="font-size:40px; font-family: 'Noto Serif Ethiopic', serif;">
                                የሰላም ሚኒስቴር
                            </span>
                        </h1>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <hr />
    </div>

    <p>
        List of Volunteers Placed for Training
    </p>
<table border="1" style="width: 100%;margin-top:30px;border-collapse:collapse;">
    <thead>
        <th>SNo.</th>
        <th>Name</th>
        <th>Region</th>
        <th>Zone</th>
        <th>Training Center</th>
    </thead>
    <tbody>
        @foreach ($placedVolunteers as $placedVolunteer)
            <tr>
                <td>{{ $loop->index + 1}}</td>
                <td>{{ $placedVolunteer->approvedApplicant->volunteer->name() }}</td>
                <td>{{ $placedVolunteer->approvedApplicant->volunteer->woreda->zone->region->name }}</td>
                <td>{{ $placedVolunteer->approvedApplicant->volunteer->woreda->zone->name }}</td>
                <td>{{ $placedVolunteer->trainingCenterCapacity->trainingCenter->name }}</td>
            </tr>
        @endforeach

    </tbody>
</table>


</body>

</html>
