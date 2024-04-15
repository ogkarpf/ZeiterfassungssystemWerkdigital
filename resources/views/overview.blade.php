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
        <div>
            <h1 class="text-center">Übersicht</h1>
            <div class="DateBox">
                <a href="{{ route('overview') }}">Alle</a> |
                @foreach($availableDays as $day)
                    <a href="{{ route('overview', ['day' => \Carbon\Carbon::createFromFormat('d.m.Y', $day)->format('d-m-Y')]) }}">{{ $day }}</a> |
                @endforeach
            </div>

            <h2 class="text-center"><a href="/">Zurück zur Zeiterfassung</a></h2>

            <div class="OverviewBox">
                @foreach($groupedWorkTimes as $date => $dayWorkTimes)
                    <h2>{{ $date }}</h2>
                    @foreach($dayWorkTimes as $workTime)
                        @if($workTime->start_time && $workTime->end_time)
                            <p>{{ $workTime->start_time->format('H:i') }} - {{ $workTime->end_time->format('H:i') }}</p>
                        @endif
                    @endforeach
                    <p>
                        @if(isset($totalWorkHours[$date]))
                            Gesamt {{ $totalWorkHours[$date] }} Stunden
                        @else
                            Keine Arbeitszeiten vorhanden
                        @endif
                    </p>
                    <br>
                @endforeach
            </div>
        </div>
    </body>
</html>
