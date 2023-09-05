<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        /* Inline CSS styles */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            margin: 0 0 20px;
        }

        p {
            margin: 0 0 10px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4caf50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Email Verification</h1>
        <p>Dear User,</p>
        <p>Thank you for registering on our website. To complete your registration, please click the button below to
            verify your email address:</p>
        <p><a href="{{ route('verify.email', $data) }}" class="button">Verify Email</a></p>
        <p>If the button above doesn't work, you can copy and paste the following URL into your browser:</p>
        <p>[VERIFICATION_URL]</p>
        <p>If you didn't sign up for our website, please ignore this email.</p>
        <p>Best regards,</p>
        <p>The Website Team</p>
    </div>
</body>

</html>
