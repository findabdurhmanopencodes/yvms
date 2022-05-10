<!DOCTYPE html>
<html>

<head>
    <title>Welcome Email</title>
</head>

<body>
    <h2>Welcome to the site {{ $volunteer->name() }}</h2>
    <br />
    Your registered email-id is {{ $volunteer->email }} , Please click on the below link to verify your email account
    <br />
    <a href="{{ route('volunteer.email.verify', ['token' => $volunteer->verifyVolunteer->token]) }}">Verify Email</a>
</body>

</html>
