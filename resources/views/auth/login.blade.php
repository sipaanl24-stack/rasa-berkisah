@php
    $images = [
        '1.jpeg',
        '2.jpeg',
        '3.jpeg',
        '4.jpeg',
        '5.jpeg',
        '6.jpeg',
        '7.jpeg',
    ];
@endphp

<!DOCTYPE html>
<html>
<head>
    <title>Login Karyawan</title>
    <meta charset="utf-8">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

    <!-- Background Gallery -->
    <div class="background-grid">
        @for($i = 0; $i < 100; $i++)
            <div class="tile">
                <img src="{{ asset('gambar/login/' . $images[$i % count($images)]) }}">
            </div>
        @endfor
    </div>

    <div class="overlay"></div>
    <div class="blur-layer"></div>

    <!-- Login Form -->
    <div class="login-wrapper">
        <div class="login-card">

            <div class="logo">
                <h2>Rasa Berkisah</h2>
                <p>& Coffee Point</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger"> {{ session('error') }} </div>
            @endif

            <form action="{{ url('/login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required> 
                </div>

                <button class="btn btn-login text-white w-100"> Login </button>
            </form>
        </div>
    </div>
</body>
</html>