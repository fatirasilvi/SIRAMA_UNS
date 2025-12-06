<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIRAMA UNS</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f5f5;
        }

        .login-wrapper {
            background: white;
            border-radius: 15px 0 0 15px;
            padding: 50px 60px;
        }

        .right-box {
            background: linear-gradient(180deg, #0F3D91, #0A2A63);
            color: white;
            padding: 50px;
            border-radius: 0 15px 15px 0;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #777;
        }

        .input-group-custom input {
            padding-left: 40px;
            height: 45px;
        }

        .btn-login {
            background: #2349C6;
            color: white;
            width: 100%;
            height: 45px;
            border-radius: 6px;
            font-weight: 600;
        }

        a {
            color: #2349C6;
            font-weight: 500;
        }
    </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="row shadow" style="border-radius: 15px; overflow:hidden; max-width:1100px;">

        <!-- LEFT SIDE -->
        <div class="col-md-6 login-wrapper">

            <h3 class="fw-bold mb-4" style="color:#2349C6;">Login</h3>

            <form action="{{ route('dosen.login.store') }}" method="POST">
                @csrf

                <!-- NIP -->
                <div class="mb-3 input-group-custom">
                    <i class="bi bi-person"></i>
                    <input type="text" name="nip" class="form-control" placeholder="NIP" required>
                </div>

                <!-- PASSWORD -->
                <div class="mb-3 input-group-custom">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <button class="btn btn-login mt-2">Login</button>

                <div class="mt-3">
                    Belum punya akun?
                    <a href="/dosen/register">Daftar di sini</a>
                </div>
            </form>

        </div>

        <!-- RIGHT SIDE -->
        <div class="col-md-6 right-box">
            <h2 class="fw-bold mb-4">Selamat Datang<br>di SIRAMA UNS</h2>

            <p>
                Portal Sistem Riset dan Pengabdian Masyarakat Universitas Sebelas Maret.
            </p>

            <p class="mt-4">
                Masuk untuk mengakses layanan penelitian, pengabdian, dan manajemen dokumen dosen.
            </p>
        </div>

    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

</body>
</html>
