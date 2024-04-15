<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}"></script>

        <!-- Styles -->
        <style>
            
        </style>
    </head>
    <body>
        <div>
            <h1>Zeiterfassung</h1>
            <h2 id="timer">Time: 00:00</h2>
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
        </div>
    </body>
</html>
