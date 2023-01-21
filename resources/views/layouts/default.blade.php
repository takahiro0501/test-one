<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('sentences.user_title') }}</title>
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
</head>
<body>
    <div class="user-contens">
        <header class="user-header">
            <x-user-header />
        </header>
        <main>
            {{ $slot }}
        </main>
        <footer class="user-footer">
            <x-user-footer />        
        </footer>
    </div>
</body>
</html>

