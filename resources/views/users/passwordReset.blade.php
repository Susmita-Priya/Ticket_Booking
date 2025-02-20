<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
</head>
<body>
    <h1>Password Reset Request</h1>
    <p>Hello {{ $user->name }},</p>
    <p>You have requested to reset your password. Use the following reset code to reset your password:</p>
    <p><strong>Reset code:</strong> {{ $resetCode }}</p>
    <p>If you did not request this, please ignore this email.</p>
</body>
</html>