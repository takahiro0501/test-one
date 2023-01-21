<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>管理者メニュー</title>
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
</head>
<body>
    <div class="admin-contens">
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html>
