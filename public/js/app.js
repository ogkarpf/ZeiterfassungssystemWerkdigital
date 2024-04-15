
var timerInterval; // Variable zum Speichern des Intervalls für den Timer

var timerCount = 0; // Variable zum Speichern des aktuellen Timer-Werts

function StartTimer() {
    var startImg = document.getElementById("StartImg");
    var stopImg = document.getElementById("StopImg");
    var timerElement = document.getElementById("timer");

    var startActive = startImg.src.includes("Start-Active.png");

    if (!startActive) {
        timerCount = 0;
        timerElement.textContent = "Time: " + formatTime(timerCount);

        startImg.src = startImg.src.replace("Start-NotActive.png", "Start-Active.png");
        stopImg.src = stopImg.src.replace("Stop-Active.png", "Stop-NotActive.png");

        // Starte den Timer und aktualisiere ihn jede Sekunde
        timerInterval = setInterval(function() {
            timerCount++;
            timerElement.textContent = "Time: " + formatTime(timerCount);
        }, 1000); // Timer wird alle 1000ms (1 Sekunde) aktualisiert
    }
}

function StopTimer() {
    var startImg = document.getElementById("StartImg");
    var stopImg = document.getElementById("StopImg");

    var startActive = startImg.src.includes("Start-Active.png");
    var stopActive = stopImg.src.includes("Stop-Active.png");

    if (!stopActive && startActive) {
        stopImg.src = stopImg.src.replace("Stop-NotActive.png", "Stop-Active.png");
        startImg.src = startImg.src.replace("Start-Active.png", "Start-NotActive.png");

        // Stoppe den Timer
        clearInterval(timerInterval);
    }
}

function formatTime(seconds) {
    var minutes = Math.floor(seconds / 60);
    var remainingSeconds = seconds % 60;

    // Füge führende Nullen hinzu, wenn nötig
    var formattedMinutes = minutes < 10 ? "0" + minutes : minutes;
    var formattedSeconds = remainingSeconds < 10 ? "0" + remainingSeconds : remainingSeconds;

    return formattedMinutes + ":" + formattedSeconds;
}


