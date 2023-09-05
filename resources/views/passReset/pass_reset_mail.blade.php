<!DOCTYPE html>
<html>

<head>
    <title>Password Reset</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.5; color: #333333;">

    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="logo.png" alt="Company Logo" style="max-width: 150px;">
        </div>

        <div style="margin-bottom: 30px;">
            <p>Dear [User],</p>
            <p>We have received a request to reset the password for your account. To ensure the security of your
                account, please follow the instructions below to reset your password:</p>
        </div>
        <p>
            <a href="{{ route('pass.reset.form', $data) }}"
                style="display: inline-block; background-color: #4CAF50; color: white; text-decoration: none; padding: 10px 20px; border-radius: 5px;">Reset
                Password </a>
        </p>
        <p>If you did not request a password reset, please ignore this email. Your account will remain secure, and no
            changes will be made.</p>
        <p>For security reasons, please do not share this email with anyone. Ensure that you choose a strong, unique
            password that is not easily guessable.</p>
        <p>If you encounter any issues or require further assistance, please contact our support team at <a
                href="mailto:support@example.com">support@example.com</a>.</p>
        <div style="margin-top: 30px; text-align: center; color: #777777; font-size: 12px;">
            <p>Thank you for your attention to this matter.</p>
            <p>Best regards,<br>[Your Company Name]</p>
        </div>
    </div>
</body>

</html>
