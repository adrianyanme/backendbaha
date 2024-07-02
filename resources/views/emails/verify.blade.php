<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 100%;
            max-width: 600px;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
        }
        .header img {
            width: 100px;
        }
        .content {
            text-align: center;
            padding: 20px 0;
        }
        .content h1 {
            color: #333333;
        }
        .content p {
            color: #555555;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #ff007b;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            color: #999999;
            font-size: 12px;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="blob:https://web.telegram.org/8d9d2f34-24fd-4e8c-b335-2b5feee726ac" alt="Logo">
        </div>
        <div class="content">
            <h1>Verify your email address</h1>
            <p>You’re one step away</p>
            <p>To complete your profile and start taking business rides, you'll need to verify your email address.</p>
            <a href="{{ $verificationLink }}" class="button">VERIFY</a>
            <p>Have a question? <a href="mailto:support@yourdomain.com">Reach out to our team</a></p>
        </div>
        <div class="footer">
            <p>Contact</p>
            <p>185 Berry St, Ste 5000, San Francisco, CA 94107</p>
            <p>&copy; {{ date('Y') }} Your Company, Inc.</p>
        </div>
    </div>
</body>
</html>
