<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            text-align: center;
            padding: 50px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 72px;
            margin-bottom: 10px;
            color: #e74c3c; /* Red color for error */
        }
        p {
            font-size: 18px;
            margin-bottom: 20px;
        }
        a {
            color: #3498db;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>500</h1>
        <p>Internal Server Error</p>
        <p>
            Oops! Something went wrong on our server. We're working to fix it.
            Please try again in a few moments.
        </p>
        <p>
            If the problem persists, please <a href="mailto:rendi45hp@gmail.com">contact support</a>.
        </p>
        <p>You can go back to the <a href="{{ url('/') }}">homepage</a>.</p>
    </div>
</body>
</html>