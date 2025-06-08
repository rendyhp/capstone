<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>403 - Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .error-box {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="error-box">
        <h1 class="display-3 text-danger">403</h1>
        <p class="lead">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <p>Anda akan diarahkan ke dashboard dalam <span id="countdown" class="text-primary fw-bold">5</span> detik...</p>
        <a href="/dashboard" class="btn btn-primary mt-3">Kembali Sekarang</a>
    </div>

    <script>
        let countdown = 5;
        const countdownElement = document.getElementById('countdown');

        const interval = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(interval);
                window.location.href = "/dashboard";
            }
        }, 1000);
    </script>
</body>
</html>
