<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset - HRM System</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0; background-color: #f5f5f5; color: #333;">

    <div style="max-width: 600px; margin: 20px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="https://example.com/logo.png" alt="HRM System Logo" width="150">
        </div>
        <h1 style="text-align: center; color: #007bff;">Password Reset - HRM System</h1>
        <p>Dear {{ $user->name}},</p>
        <p>We received a request to reset your password for your HRM System account.</p>
        <p>If you made this request, please click on the following link to reset your password:</p>
        <p><center><a href="{{ route('password.reset.view', ['email' => encrypt($user->email)]) }}" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 4px; margin-top: 15px;">Reset Password</a></center></p>
        <p>If you didn't make this request, you can ignore this email. Your password will remain unchanged.</p>

        <p>If you encounter any issues or have any questions, feel free to reach out to our support team at [Support Email].</p>
        <p>Thank you for choosing HRM System.</p>
        <p>Best Regards,<br>
        HRM System Team</p>
    </div>

</body>
</html>
