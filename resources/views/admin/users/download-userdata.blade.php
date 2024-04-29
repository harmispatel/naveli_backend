<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:#fff;
            padding: 20px;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px; /* Added margin-top */
        }
        .logo {
            float: right;
            width: 60px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        hr {
            border: 1px solid #ccc;
            margin: 20px 0;
        }
        .data-row {
            display: flex;
            margin-bottom: 10px;
        }
        .data-row strong {
            width: 100px; /* Adjust as needed */
        }
        .data-row:last-child {
            margin-bottom: 0; /* Remove margin from the last row */
        }
    </style>
</head>
<body>
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/frontend/logo_image/Background - 2024-02-26T151826.204.png'))) }}" alt="Logo" class="logo">
    <div class="container">
        <h2>{{$currentMonthYear}}</h2>
        <hr>
        <div class="data-columns">
            @foreach($data as $key => $value)
                <div class="data-row">
                    <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
