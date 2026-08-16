<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>

    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>

<body>

    <div class="space">
        <div class="center-glow"></div>
    </div>

    <div class="content">
        <div class="title">
            Selamat Datang
        </div>

        <div class="subtitle">
            Rasa Berkisah & Coffee Point
        </div>
    </div>

    <script>
        window.dashboardUrl = "{{ url('/dashboard') }}";
    </script>

    <script src="{{ asset('js/welcome.js') }}"></script>

</body>
</html>