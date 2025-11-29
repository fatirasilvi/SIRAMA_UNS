<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - SIRAMA UNS</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f5f5;
        }

        .left-box {
            background: linear-gradient(180deg, #0F3D91, #0A2A63);
            color: white;
            padding: 50px;
            border-radius: 15px 0 0 15px;
        }

        .title-box {
            font-size: 28px;
            font-weight: 700;
            line-height: 1.3;
        }

        .register-wrapper {
            background: white;
            border-radius: 0 15px 15px 0;
            padding: 40px 50px;
        }

        .form-control {
            padding-left: 40px;
            height: 45px;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 12px;
            font-size: 18px;
            opacity: 0.7;
        }

        .btn-register {
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
            <div class="col-md-6 left-box">
                <h2 class="title-box mb-4">Selamat Datang<br>di SIRAMA UNS</h2>
                <p>
                    Silakan membuat akun untuk mulai mengakses layanan penelitian dan pengabdian masyarakat dosen
                    di Universitas Sebelas Maret.
                </p>
                <p class="mt-4">
                    Lengkapi data diri Anda dengan benar untuk memastikan proses administrasi berjalan lancar.
                </p>
            </div>

            <!-- RIGHT SIDE -->
            <div class="col-md-6 register-wrapper">

                <h3 class="fw-bold mb-4" style="color:#2349C6;">Create Account</h3>

                @if ($errors->any())
                    <div style="color: red; margin-bottom: 10px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- FORM -->
                <form action="{{  route('dosen.register.store') }}" method="POST">
                    @csrf

                    <!-- NAME -->
                    <div class="mb-3 position-relative">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" name="nama" class="form-control" placeholder="Enter full name with title"
                            value="{{ old('nama') }}">
                    </div>

                    <!-- NIP -->
                    <div class="mb-3 position-relative">
                        <i class="bi bi-credit-card input-icon"></i>
                        <input type="text" name="nip" class="form-control" placeholder="Enter NIP"
                            value="{{ old('nip') }}">
                    </div>

                    <!-- EMAIL -->
                    <div class="mb-3 position-relative">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" name="email" class="form-control" placeholder="Enter email"
                            value="{{ old('email') }}">
                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-3 position-relative">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" name="password" class="form-control" placeholder="Enter password">
                    </div>

                    <!-- PASSWORD CONFIRM -->
                    <div class="mb-3 position-relative">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Re-enter password">
                    </div>


                    <!-- BUTTON -->
                    <button class="btn btn-register mt-2">Create Account</button>

                    <div class="mt-3 text-center">
                        Already have account?
                        <a href="/dosen/login">Login here</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

</body>

</html>