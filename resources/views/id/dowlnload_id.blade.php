<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @foreach ($html as $key=>$val)
        <div style="width: 201.6px; height: 326.4px; background-size: cover; background-image: url('img/mopfrontdes.png'); break-after: page; transform: rotate(90deg); transform-origin: 159px 159px; page-break-after: always; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: -43px; margin-left: -35px;">
            <div style="position: relative; left: 54px; top: 120px;">
                <img src="img/meti.jpg" style="width: 91px; height: 89.7px; border-radius: 50%;">
            </div>
            <p style="position: relative; left: 56px; top: 110px; background-color: inherit; font-size: 10px; color: blue;">
                <strong>ID: </strong>
            </p>
            <p style="position: relative; left: 76px; top: 89px; background-color: inherit; font-size: 10px; color: blue;">
                <strong>{{ $val->id_number }}</strong>
            </p>
            <p style="position: relative; left: 42px; top: 84px; background-color: inherit; font-size: 10px; color: blue;">
                <strong>Name: </strong>
            </p>
            <p style="position: relative; left: 76px; top: 64px; background-color: inherit; font-size: 10px; color: blue;">
                <strong>{{ $val->first_name }}  {{ $val->father_name }}</strong>
            </p>
            <p style="position: relative; left: 33px; top: 57px; background-color: inherit; font-size: 10px; color: blue;">
                <strong>Dep. Place: </strong>
            </p>
            <p style="position: relative; left: 87px; top: 36px; background-color: inherit; font-size: 10px; color: blue;">
                <strong>{{ $val->approvedApplicant->trainingPlacement->deployment->woredaIntake->woreda->name }}</strong>
            </p>
            <p style="position: relative;text-align: center; top: 24px; background-color: inherit; font-size: 13px; color: blue;">
                <strong>
                    በጎነት ለአብሮነት!
                </strong>
            </p>
            <p style="position: relative; left: 5px; top: 23px; background-color: inherit; font-size: 10px; color: blue;">
                <strong>Exp. Date: </strong>
            </p>
            <p style="position: relative; left: 54px; top: 2px; background-color: inherit; font-size: 10px; color: blue;">
                <strong>{{ $val->session->end_date_am }}</strong>
            </p>
            <p style="position: relative; left: 5px; top: 0px; background-color: inherit; font-size: 10px; color: blue;">
                <strong>Role: </strong>
            </p>
            <p style="position: relative; left: 33px; top: -21px; background-color: inherit; font-size: 10px; color: blue;">
                <strong>Volunteer</strong>
            </p>
            <div style="position: relative; float: right; top: -72px;">
                <img src="data:image{{ $exp[$key+1] }}" alt="">
            </div>
        </div>

        <div style="width: 324px; height: 210px; background-size: cover; background-image: url('img/ID_mopBack.jpg'); break-after: page; margin-left: -9px; margin-top: -9px; page-break-after: always; margin-top: -53px; margin-left: -42px;">
            <p style="position: relative; left: 55px; top: 32px; background-color: inherit; font-size: 10px; color: white; letter-spacing: 0.5px;">
                web: www.mop.gov.et
            </p>
            <p style="position: relative; left: 55px; top: 24px; background-color: inherit; font-size: 10px; color: white; letter-spacing: 0.5px;">
                mail: mop@gmail.com
            </p>
            <p style="position: relative; left: 168px; top: -10px; background-color: inherit; font-size: 10px; color: white; letter-spacing: 0.5px;">
                +251(0)471117588
            </p>
            <div style="position: relative; float: right; top: -68px;">
                <img src="img/meti.jpg" alt="" style="width: 67px; height: 61px; border-radius: 5%;">
            </div>
            <p style="position: relative; left: 8px; top: -10px; background-color: inherit; font-size: 10px; color: black; font-style: italic; letter-spacing: 0.5px;">
                <strong>Full Name:</strong>                
            </p>
            <p style="position: relative; left: 8px; top: -18px; background-color: inherit; font-size: 10px; color: black; letter-spacing: 0.5px;">
                <strong>{{ $val->first_name }}  {{ $val->father_name }}</strong>
            </p>
            <div style="position: relative; left: 142px; top: -63px;">
                <img src="data:image{{ $expBar[$key+1] }}" style="color: black">
            </div>
            <p style="position: relative; left: 8px; top: -80px; background-color: inherit; font-size: 10px; color: black; font-style: italic; letter-spacing: 0.5px;">
                <strong>Nationality:</strong>
            </p>
            <p style="position: relative; left: 8px; top: -89px; background-color: inherit; font-size: 10px; color: black; letter-spacing: 0.5px;">
                <strong>Ethiopian</strong>
            </p>
            <p style="position: relative; left: 8px; top: -93px; background-color: inherit; font-size: 10px; color: black; font-style: italic; letter-spacing: 0.5px;">
                <strong>Date of Issue:</strong>
            </p>
            <p style="position: relative; left: 8px; top: -102px; background-color: inherit; font-size: 10px; color: black; letter-spacing: 0.5px;">
                <strong>{{ $val->approvedApplicant->trainingPlacement->deployment->issued_date_am }}</strong>
            </p>
            <p style="position: relative; left: 200px; top: -164px; background-color: inherit; font-size: 10px; color: black; font-style: italic; letter-spacing: 0.5px;">
                <strong>Deployment place</strong>
            </p>
            <p style="position: relative; left: 200px; top: -173px; background-color: inherit; font-size: 10px; color: black; letter-spacing: 0.5px;">
                <strong>{{ $val->approvedApplicant->trainingPlacement->deployment->woredaIntake->woreda->name }}</strong>
            </p>
            <p style="position: relative; left: 200px; top: -178px; background-color: inherit; font-size: 10px; color: black; font-style: italic; letter-spacing: 0.5px;">
                <strong>Exp. Date</strong>
            </p>
            <p style="position: relative; left: 200px; top: -186px; background-color: inherit; font-size: 10px; color: black; letter-spacing: 0.5px;">
                <strong>{{ $val->session->end_date_am }}</strong>
            </p>
            <div style="left: 30px; top: -205px; width: 180px; background-color: inherit; position: relative;">
                <p style="text-align: center; font-size: 9px; position: relative; color: rgb(131, 218, 209); letter-spacing: 0.5px;">
                    <strong>I certify that bearer of this Id card is an employee of Jimma University</strong>
                </p>
            </div>
        </div>
    @endforeach
</body>
</html>