<html>

<head>
    <title>Confirmation</title>
</head>

<body>
    Hello {{ $email_data['name'] }}
    <br><br>
    Welcome to my website!
    <br>
    Please click the below link to verify your email and activate your account
    <br><br>
    <a href="http://localhost:8000/verify?code={{ $email_data['verification_code'] }}">Click Here</a>

    <br><br>
    Thank you!
</body>

</html>
