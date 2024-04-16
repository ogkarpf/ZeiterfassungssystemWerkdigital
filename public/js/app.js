
var timerInterval; 
var timerCount = 0; 

function StartTimer() {
    var startImg = document.getElementById("StartImg");
    var stopImg = document.getElementById("StopImg");
    var timerElement = document.getElementById("timer");

    var startActive = startImg.src.includes("Start-Active.png");

    if (!startActive) {
        fetch('/api/work-time/start', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({}) 
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            
            console.log(data);
        })
        .catch(error => {
            console.error('There has been a problem with your fetch operation:', error);
        });
        timerCount = 0;
        timerElement.textContent = "Time: " + formatTime(timerCount);

        startImg.src = startImg.src.replace("Start-NotActive.png", "Start-Active.png");
        stopImg.src = stopImg.src.replace("Stop-Active.png", "Stop-NotActive.png");

        timerInterval = setInterval(function() {
            timerCount++;
            timerElement.textContent = "Time: " + formatTime(timerCount);
        }, 1000); 
    }
}

function StopTimer() {
    var startImg = document.getElementById("StartImg");
    var stopImg = document.getElementById("StopImg");

    var startActive = startImg.src.includes("Start-Active.png");
    var stopActive = stopImg.src.includes("Stop-Active.png");

    var userid = document.getElementById("userid").value;

    if (!stopActive && startActive) {
        fetch('/api/work-time/stop', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({}) 
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            
            console.log(data);
        })
        .catch(error => {
            console.error('There has been a problem with your fetch operation:', error);
        });

        fetch('/mail/sendmail/' + userid, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({}) 
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error('There has been a problem with your fetch operation:', error);
        });
        
        stopImg.src = stopImg.src.replace("Stop-NotActive.png", "Stop-Active.png");
        startImg.src = startImg.src.replace("Start-Active.png", "Start-NotActive.png");

        clearInterval(timerInterval);
    }
}

function formatTime(seconds) {
    var minutes = Math.floor(seconds / 60);
    var remainingSeconds = seconds % 60;

    var formattedMinutes = minutes < 10 ? "0" + minutes : minutes;
    var formattedSeconds = remainingSeconds < 10 ? "0" + remainingSeconds : remainingSeconds;

    return formattedMinutes + ":" + formattedSeconds;
}


