<!DOCTYPE html>
<html>
<head>
<title>Verify Your email</title>
</head>
<body>
<h2>Welcome to http://donalds.in {{$user['first_name']}}</h2>
<br/>
Your registered email-id is {{$user['email']}} , Please click on the below link to verify your email account
<br/>
<a href="{{url('user/verify', $user->verifyUser->token)}}">Verify Email</a>
</body>
</html>
