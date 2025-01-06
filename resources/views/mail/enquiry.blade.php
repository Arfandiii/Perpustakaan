<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
    <style>
        /* Tailwind CSS di-inline untuk kompatibilitas email */
        h2 {
            margin-top: 8px
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8fafc;
            border-radius: 8px;
            font-family: 'Arial', sans-serif;
        }

        .header {
            background-color: #4f46e5;
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 20px;
            font-weight: bold;
            border-radius: 8px 8px 0 0;
        }

        .content {
            padding: 20px;
            font-size: 16px;
            color: #374151;
        }

        .button {
            display: inline-block;
            background-color: #6366f1;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin-top: 20px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }

        .button:hover {
            background-color: #4f46e5;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #6b7280;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            Hallo Admin
        </div>
        <div class="content">
            <h2>Pesan dari: {{ $data['first-name'] }}</h2>
            <p>Email: {{ $data['email'] }}</p>
            <p>Pesan: {{ $data['message'] }}</p>
            <a href="{{ $url }}" class="button">Button Text</a>
        </div>
        <div class="footer">
            Thanks,<br>
            {{ config('app.name') }}
        </div>
    </div>
</body>

</html>