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
<body style="">
    @if ($check == 'deployment' && $trainer == null)
    @foreach ($html as $key=>$val)
        <div style="width: 201.6px; height: 326.4px; background-size: cover; background-image: url('img/mopfrontdes.png'); break-after: page; transform: rotate(90deg); transform-origin: 159px 159px; page-break-after: always; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: -43px; margin-left: -35px;">
            <div style="position: relative; left: 54px; top: 120px;">
                <img src="img/profile_empty.jpg" style="width: 91px; height: 89.7px; border-radius: 50%;">
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
            <p style="position: relative;text-align: center; top: 18px; background-color: inherit; font-size: 13px; color: blue;">
                <strong style="font-family: 'Noto Serif Ethiopic'"> 
                    በጎነት ለአብሮነት
                </strong><strong>!</strong>
            </p>
            <p style="position: relative; left: 5px; top: 20px; background-color: inherit; font-size: 10px; color: blue;">
                <strong>Exp. Date: </strong>
            </p>
            <p style="position: relative; left: 54px; top: -1px; background-color: inherit; font-size: 10px; color: blue;">
                <strong>{{ $val->session->end_date_am }}</strong>
            </p>
            <p style="position: relative; left: 5px; top: -5px; background-color: inherit; font-size: 10px; color: blue;">
                <strong>Role: </strong>
            </p>
            <p style="position: relative; left: 33px; top: -26px; background-color: inherit; font-size: 10px; color: blue;">
                <strong>Volunteer</strong>
            </p>
            <div style="position: relative; float: right; top: -79px;">
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
                <img src="img/profile_empty.jpg" alt="" style="width: 67px; height: 61px; border-radius: 5%;">
            </div>
            <p style="position: relative; left: 8px; top: -10px; background-color: inherit; font-size: 10px; color: black; font-style: italic; letter-spacing: 0.5px;">
                <strong>Full Name:</strong>                
            </p>
            <p style="position: relative; left: 8px; top: -18px; background-color: inherit; font-size: 10px; color: black; letter-spacing: 0.5px;">
                <strong>{{ $val->first_name }}  {{ $val->father_name }}</strong>
            </p>
            <div style="position: relative; left: 142px; top: -60px;">
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
                <strong>{{ $issued_date }}</strong>
            </p>
            <p style="position: relative; left: 200px; top: -160px; background-color: inherit; font-size: 10px; color: black; font-style: italic; letter-spacing: 0.5px;">
                <strong>Deployment place</strong>
            </p>
            <p style="position: relative; left: 200px; top: -169px; background-color: inherit; font-size: 10px; color: black; letter-spacing: 0.5px;">
                <strong>{{ $val->approvedApplicant->trainingPlacement->deployment->woredaIntake->woreda->name }}</strong>
            </p>
            <p style="position: relative; left: 200px; top: -174px; background-color: inherit; font-size: 10px; color: black; font-style: italic; letter-spacing: 0.5px;">
                <strong>Exp. Date</strong>
            </p>
            <p style="position: relative; left: 200px; top: -182px; background-color: inherit; font-size: 10px; color: black; letter-spacing: 0.5px;">
                <strong>{{ $val->session->end_date_am }}</strong>
            </p>
            <div style="left: 10px; top: -205px; width: 180px; background-color: inherit; position: relative;">
                <p style="text-align: center; font-size: 9px; position: relative; color: rgb(131, 218, 209); letter-spacing: 0.5px;">
                    <strong>I certify that bearer of this Id card is an employee of Jimma University</strong>
                </p>
            </div>
        </div>
    @endforeach
    @elseif($check == 'checkedIn' && $trainer == null)
        @foreach ($html as $key=>$val)
        
        @if ($key%4 === 0)
        <div style="clear: both; margin-top:25px;"></div>
        @endif
            @if ($key%8 !== 0 || $key == 0)
                <div style="width: 201.6px; height: 326.4px; background-size: cover; background-image: url('img/mopfrontdes.png'); float: left; margin-right: 30px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: -30px;">
                    <div style="position: relative; left: 54px; top: 120px;">
                        <img src="img/profile_empty.jpg" style="width: 91px; height: 89.7px; border-radius: 50%;">
                    </div>
                    <p style="position: relative; left: 56px; top: 110px; background-color: inherit; font-size: 10px; color: blue;">
                        <strong>ID: </strong>
                    </p>
                    <p style="position: relative; left: 76px; top: 88.3px; background-color: inherit; font-size: 10px; color: blue;">
                        <strong>{{ $val->id_number }}</strong>
                    </p>
                    <p style="position: relative; left: 42px; top: 84px; background-color: inherit; font-size: 10px; color: blue;">
                        <strong>Name: </strong> 
                    </p>
                    <p style="position: relative; left: 76px; top: 62.5px; background-color: inherit; font-size: 10px; color: blue;">
                        <strong>{{ $val->first_name }}  {{ $val->father_name }}</strong>
                    </p>
                    <p style="position: relative; left: 33px; top: 57px; background-color: inherit; font-size: 10px; color: blue;">
                        <strong>Training Center: </strong>
                    </p>
                    <p style="position: relative; left: 112px; top: 36px; background-color: inherit; font-size: 10px; color: blue;">
                        <strong>{{ $val->approvedApplicant->trainingPlacement->trainingCenterCapacity->trainingCenter->code }}</strong>
                    </p>
                    <p style="position: relative;text-align: center; top: 18px; background-color: inherit; font-size: 13px; color: blue;">
                        <strong style="font-family: 'Noto Serif Ethiopic'">
                            በጎነት ለአብሮነት
                        </strong><strong>!</strong>
                    </p>
                    <p style="position: relative; left: 5px; top: 15px; background-color: inherit; font-size: 10px; color: blue;">
                        <strong>Exp. Date: </strong>
                    </p>
                    <p style="position: relative; left: 54px; top: -6px; background-color: inherit; font-size: 10px; color: blue;">
                        <strong>{{ $val->session->end_date_am }}</strong>
                    </p>
                    <p style="position: relative; left: 5px; top: -8px; background-color: inherit; font-size: 10px; color: blue;">
                        <strong>Role: </strong>
                    </p>
                    <p style="position: relative; left: 33px; top: -29px; background-color: inherit; font-size: 10px; color: blue;">
                        <strong>Volunteer</strong>
                    </p>
                    <div style="position: relative; float: right; top: -79px;">
                        <img src="data:image{{ $exp[$key+1] }}" alt="">
                    </div>
                </div>
            @else
                <div style="break-after: page; page-break-after: always;">
                </div>
                <div style="width: 201.6px; height: 326.4px; background-size: cover; background-image: url('img/mopfrontdes.png'); float: left; margin-right: 30px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: -30px;">
                    <div style="position: relative; left: 54px; top: 120px;">
                        <img src="img/profile_empty.jpg" style="width: 91px; height: 89.7px; border-radius: 50%;">
                    </div>
                    <p style="position: relative; left: 56px; top: 110px; background-color: inherit; font-size: 10px; color: blue;">
                        <strong>ID: </strong>
                    </p>
                    <p style="position: relative; left: 76px; top: 88.3px; background-color: inherit; font-size: 10px; color: blue;">
                        <strong>{{ $val->id_number }}</strong>
                    </p>
                    <p style="position: relative; left: 42px; top: 84px; background-color: inherit; font-size: 10px; color: blue;">
                        <strong>Name: </strong> 
                    </p>
                    <p style="position: relative; left: 76px; top: 62.5px; background-color: inherit; font-size: 10px; color: blue;">
                        <strong>{{ $val->first_name }}  {{ $val->father_name }}</strong>
                    </p>
                    <p style="position: relative; left: 33px; top: 57px; background-color: inherit; font-size: 10px; color: blue;">
                        <strong>Training Center: </strong>
                    </p>
                    <p style="position: relative; left: 112px; top: 36px; background-color: inherit; font-size: 10px; color: blue;">
                        <strong>{{ $val->approvedApplicant->trainingPlacement->trainingCenterCapacity->trainingCenter->code }}</strong>
                    </p>
                    <p style="position: relative;text-align: center; top: 18px; background-color: inherit; font-size: 13px; color: blue;">
                        <strong style="font-family: 'Noto Serif Ethiopic'">
                            በጎነት ለአብሮነት
                        </strong><strong>!</strong>
                    </p>
                    <p style="position: relative; left: 5px; top: 15px; background-color: inherit; font-size: 10px; color: blue;">
                        <strong>Exp. Date: </strong>
                    </p>
                    <p style="position: relative; left: 54px; top: -6px; background-color: inherit; font-size: 10px; color: blue;">
                        <strong>{{ $val->session->end_date_am }}</strong>
                    </p>
                    <p style="position: relative; left: 5px; top: -8px; background-color: inherit; font-size: 10px; color: blue;">
                        <strong>Role: </strong>
                    </p>
                    <p style="position: relative; left: 33px; top: -29px; background-color: inherit; font-size: 10px; color: blue;">
                        <strong>Volunteer</strong>
                    </p>
                    <div style="position: relative; float: right; top: -79px;">
                        <img src="data:image{{ $exp[$key+1] }}" alt="">
                    </div>
                </div>
            @endif
        @endforeach
        {{-- @dd('sdfsdfds') --}}

    @elseif($check == 'checkedIn' && $trainer == 'trainer')
        @foreach ($html as $key=>$val)
            <div style="width: 220px; height: 339px; background-size: cover; background-image: url('img/id_page_1.jpg'); margin: 2vh; break-after: page; break-before: page;">
                <div style="position: relative; left: 7px; top: 75.123px;">
                    <img src="img/blank.png" style="width: 206px; height: 257.7px;" alt="">
                </div>
                <p style="position: relative; left: 12px; top: -195px; background-color: inherit; font-size: 11px; color: rgb(1, 177, 242);">
                    <strong>Ethiopian National Volunteer Community</strong>
                </p>
                <p style="position: relative; left: 37px; top: -207px; background-color: inherit; font-size: 11px; color: rgb(1, 177, 242);">
                    <strong>Development Service Program</strong>
                </p>
                <p style="position: relative; left: 39px; top: -211px; background-color: inherit; font-size: 18px; color: rgb(1, 177, 242);">
                    <strong>{{ ($userType == 'mop user')?'Mop Coordinator':'Master Trainer' }}</strong>
                </p>
                <p style="position: relative; left: 18px; top: -211px; background-color: inherit; font-size: 12.5px; color: rgb(0, 0, 0);">
                    <strong>Full Name: </strong>
                </p>
                <p style="position: relative; left: 85px; top: -237px; margin-right: 45px; background-color: inherit; font-size: 11px; color: rgb(0, 0, 0);">
                    <strong>{{ ($userType == 'mop user')? $val->user->first_name.' '.$val->user->father_name : $val->master->user->first_name.' '.$val->master->user->father_name   }}</strong>
                </p>
                <p style="position: relative; left: 18px; top: -242px; background-color: inherit; font-size: 12.5px; color: rgb(0, 0, 0);">
                    <strong>Training Center:</strong> 
                </p>
                <p style="position: relative; left: 117px; top: -268px; background-color: inherit; font-size: 11px;">
                    <strong>{{ $center }}</strong>
                </p>
                <p style="position: relative; left: 18px; top: -271px; background-color: inherit; font-size: 12.5px; color: rgb(0, 0, 0);">
                    <strong>Exp. Date: </strong>
                </p>
                <p style="position: relative; left: 79px; top: -296px; background-color: inherit; font-size: 11px; color: rgb(0, 0, 0);">
                    <strong>{{ $end_date }}</strong>
                </p>
                <p style="position: relative; left: 2px; top: -290px; background-color: inherit; font-size: 13px; color: rgb(1, 177, 242); text-align: center;">
                    <strong style="font-family: 'Noto Serif Ethiopic'">ብሔራዊ የበጎ ፈቃድ ማህበረሰብ አገልገሎት</strong>
                </p>
                <p style="position: relative; left: 45px; top: -300px; background-color: inherit; font-size: 19px; color: rgb(1, 177, 242);">
                    <strong>"</strong>
                    <strong style="font-family: 'Noto Serif Ethiopic'">በጎነት ለአብሮነት</strong>
                    <strong>"!</strong>
                </p>
            </div>
        @endforeach
    @endif
</body>
</html>