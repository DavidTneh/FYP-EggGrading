<!DOCTYPE html>
<html>

<head>
    <title>Welcome to Our Platform!</title>
</head>

<body>
    <h1>Hello, {{ $name }}!</h1>
    <p>Thank you for registering with us. Please verify your email by clicking the link below:</p>
    <a href="{{ $verificationUrl }}">Verify Email Address</a>
    <p>Thank you for joining us!</p>
</body>

</html>