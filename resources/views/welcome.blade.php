<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}"></script>

    </head>
    <body>
        <input id="userid" value="{{ auth()->id() }}" hidden>
        <div>
            <h1 class="text-center">Zeiterfassung</h1>
            <h2 class="text-center" id="timer">Time: 00:00</h2>
            <table>
                <tr>
                    <td>
                        <img id="StartImg" src="img/Start-NotActive.png" alt="Start" onclick="StartTimer()">
                    </td>
                    <td>
                        <img id="StopImg" src="img/Stop-NotActive.png" alt="Stop" onclick="StopTimer()">
                    </td>
                </tr>
            </table>
            <h2 class="text-center"><a href="/overview">Übersicht</a></h1>
        </div>
    </body>
</html>
