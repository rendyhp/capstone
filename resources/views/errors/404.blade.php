<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
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
            color: #e12121;
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
        <h1>404</h1>
        <hr>
        <h3>Page not Found</h3>
        <p>Halaman tidak ada atau tidak dapat ditemukan</p>
        <p>Kamu akan diarahkan ke <a href="{{ url('/') }}">homepage</a> dalam <span id="countdown"
                class="text-primary fw-bold">10</span> detik...</p>
        <p>Atau kamu bisa klik link di atas untuk kembali sekarang.</p>
    </div>

    <script>
        let countdown = 10;
        const countdownElement = document.getElementById('countdown');

        const interval = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;
            if (countdown <= 0) {
                clearInterval(interval);
                window.location.href = "{{ url('/') }}";
            }
        }, 1000);
    </script>
</body>

</html>