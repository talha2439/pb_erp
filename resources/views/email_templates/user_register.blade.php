<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to HRM System</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0; background-color: #f5f5f5; color: #333;">

    <div style="max-width: 600px; margin: 20px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="https://example.com/logo.png" alt="HRM System Logo" width="150">
        </div>
        <h1 style="text-align: center; color: #007bff;">Welcome to HRM System</h1>
        <p>Dear {{ $data['name'] }},</p>
        <p>Welcome to HRM System! We are thrilled to have you join our platform. Your registration is confirmed, and you are now part of our community dedicated to simplifying coupon management.</p>
        <p>Below are your login credentials:</p>
        <ul style="padding-left: 20px;">
            <li><strong>Email:</strong> {{ $data['email'] }}</li>
            <li><strong>Password:</strong> {{ $password }}</li>
        </ul>
        <p>Please keep this information secure. If you ever forget your password, you can reset it using the "Forgot Password" option on the login page.</p>
        <p>To get started, please click on the following link to access the HRM System Admin Dashboard:</p>
        <p><center><a href="{{ route('dashboard') }}" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 4px; margin-top: 15px;">Admin Dashboard</a></center></p>
        <p>Once logged in, you will have access to a range of features to help you manage your coupons efficiently. If you encounter any issues or have any questions, feel free to reach out to our support team at [Support Email].</p>
        <p>Thank you for choosing HRM System. We look forward to assisting you in optimizing your coupon management process.</p>
        <p>Best Regards,<br>
        HRM System Team</p>
    </div>

</body>
</html>
