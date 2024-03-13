<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Forget Password Email</h1>

    You can reset password from bellow link:
    <a href="{{ route('reset.password.get', $token) }}">Reset Password</a>
</body>
</html>