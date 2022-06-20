<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&family=Noto+Serif+Ethiopic:wght@700&display=swap" rel="stylesheet">
</head>

<body style="font-family: 'EB Garamond', serif;">
    <header>
        <table style="border-collapse: collapse;width: 100%;margin:0px;border-spacing:0px;">
            <tbody>
                <tr style="padding:0px;height:50px;background-color:rgb(226, 243, 248);">
                    <td >
                        <div style="padding:0px;">
                            <img src="img/logo_peace.png" alt="" style="width: 103px; height: 103px;">
                        </div>
                    </td>
                    <td style="color:#01afee;padding:0px; margin:0%;">
                        <div style="height: 30px;">
                            <h1>
                               <span style="font-family: 'EB Garamond', serif;, serif;font-size:30px;"> Ministry Of Peace&nbsp; |</span>
                                <span style="font-size:30px; font-family: 'Noto Serif Ethiopic', serif;">
                                    የሰላም ሚኒስቴር
                                </span>
                            </h1>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr />
    </header>
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
