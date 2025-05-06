<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verification Email</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px;">
    <div style="background: #ffffff; padding: 20px; border-radius: 8px; max-width: 600px; margin: auto;">
        <h2 style="color: #333;">Hello, {{ $details['name'] }}!</h2>
        <p>{{ $details['message'] }}</p>

        <h3 style="color: #555;">Your Verification Code:</h3>
        <div style="font-size: 24px; font-weight: bold; color: #4F46E5;">{{ $details['code'] }}</div>

        <p style="margin-top: 20px;">If you did not request this email, please ignore it.</p>

        <p style="margin-top: 30px;">Thanks,<br><strong>Accountagov</strong></p>
    </div>
</body>
</html>
