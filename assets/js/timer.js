let timerId = 0;
const timers = {};

// Mostrar los controles para agregar el temporizador dentro de la misma página
document.getElementById('createTimerButton').addEventListener('click', () => {
    const description = document.getElementById('description').value;
    const backgroundColor = document.getElementById('backgroundColor').value;
    const timerType = document.getElementById('timerType').value;
    const countdownTime = document.getElementById('countdownTime').value;

    createTimer(description, backgroundColor, timerType, countdownTime);

    // Limpiar entradas
    document.getElementById('description').value = '';
    document.getElementById('backgroundColor').value = '#ffffff';
    document.getElementById('timerType').value = 'countup';
    document.getElementById('countdownTime').value = '';
    document.getElementById('countdownOptions').style.display = 'none';
});

document.getElementById('timerType').addEventListener('change', () => {
    const timerType = document.getElementById('timerType').value;
    document.getElementById('countdownOptions').style.display = timerType === 'countdown' ? 'block' : 'none';
});

function createTimer(description, backgroundColor, timerType, countdownTime) {
    const currentTimerId = timerId; // Capturar el valor actual del timerId
    timerId++; // Incrementar el ID para futuros temporizadores

    const timerContainer = document.createElement('div');
    timerContainer.className = 'timerWrapper';
    timerContainer.style.backgroundColor = backgroundColor;

    const timerTypeDisplay = document.createElement('div');
    timerTypeDisplay.className = 'timerType';
    timerTypeDisplay.textContent = timerType === 'countdown' 
        ? `Cuenta Regresiva ${countdownTime} minutos` 
        : 'Cronómetro';

    const timerDescription = document.createElement('div');
    timerDescription.className = 'description';
    timerDescription.textContent = description;

    const timerDisplay = document.createElement('div');
    timerDisplay.className = 'timer';
    timerDisplay.textContent = '00:00:00';

    const startButton = document.createElement('button');
    startButton.textContent = 'Iniciar';
    startButton.addEventListener('click', () => startTimer(currentTimerId, timerType));

    const stopButton = document.createElement('button');
    stopButton.textContent = 'Pausar';
    stopButton.addEventListener('click', () => stopTimer(currentTimerId));
    stopButton.disabled = true;

    const resetButton = document.createElement('button');
    resetButton.textContent = 'Reiniciar';
    resetButton.addEventListener('click', () => resetTimer(currentTimerId));
    resetButton.disabled = true;

    const deleteButton = document.createElement('button');
    deleteButton.className = 'delete-button';
    deleteButton.textContent = '×';
    deleteButton.addEventListener('click', () => deleteTimer(currentTimerId, timerContainer));

    timerContainer.appendChild(timerTypeDisplay);
    timerContainer.appendChild(timerDescription);
    timerContainer.appendChild(timerDisplay);
    timerContainer.appendChild(startButton);
    timerContainer.appendChild(stopButton);
    timerContainer.appendChild(resetButton);
    timerContainer.appendChild(deleteButton);

    document.getElementById('timersContainer').appendChild(timerContainer);

    // Guardar el temporizador y el tiempo original para reiniciar correctamente
    timers[currentTimerId] = {
        display: timerDisplay,
        buttons: { start: startButton, stop: stopButton, reset: resetButton },
        type: timerType,
        originalTime: timerType === 'countdown' ? (parseInt(countdownTime, 10) * 60) : 0,
        elapsedTime: timerType === 'countdown' ? (parseInt(countdownTime, 10) * 60) : 0,
        timer: null,
        endTime: null,
        startTime: null
    };
}

function startTimer(id, timerType) {
    const timer = timers[id];
    if (timer.timer) {
        clearInterval(timer.timer);
    }
    if (timerType === 'countdown') {
        timer.endTime = Date.now() + timer.elapsedTime * 1000;
        timer.timer = setInterval(() => {
            timer.elapsedTime = Math.floor((timer.endTime - Date.now()) / 1000);
            if (timer.elapsedTime <= 0) {
                clearInterval(timer.timer);
                timer.elapsedTime = 0;

                // Cambiar el color del temporizador a rojo cuando llegue a cero
                timer.display.parentElement.style.backgroundColor = 'red';

                // Reproducir sonido de alarma
                const alarmSound = new Audio('<?php echo base_url("assets/sounds/alarm.mp3"); ?>');
                alarmSound.play();
            }
            updateDisplay(id);
        }, 1000);
    } else {
        timer.startTime = Date.now() - timer.elapsedTime * 1000;
        timer.timer = setInterval(() => {
            timer.elapsedTime = Math.floor((Date.now() - timer.startTime) / 1000);
            updateDisplay(id);
        }, 1000);
    }
    timer.buttons.start.disabled = true;
    timer.buttons.stop.disabled = false;
    timer.buttons.reset.disabled = false;
}

function stopTimer(id) {
    const timer = timers[id];
    clearInterval(timer.timer);
    timer.buttons.start.disabled = false;
    timer.buttons.stop.disabled = true;
    timer.buttons.reset.disabled = false;
}

function resetTimer(id) {
    const timer = timers[id];
    clearInterval(timer.timer);

    // Restaurar el tiempo original guardado al crear el temporizador
    timer.elapsedTime = timer.originalTime;
    updateDisplay(id);
    
    timer.buttons.start.disabled = false;
    timer.buttons.stop.disabled = true;
    timer.buttons.reset.disabled = true;
}

function deleteTimer(id, timerContainer) {
    clearInterval(timers[id].timer);
    delete timers[id];
    timerContainer.remove();
}

function updateDisplay(id) {
    const timer = timers[id];
    const hours = Math.floor(timer.elapsedTime / 3600);
    const minutes = Math.floor((timer.elapsedTime % 3600) / 60);
    const seconds = timer.elapsedTime % 60;

    // Actualizar el texto del temporizador
    timer.display.textContent = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

    // Verificar si es un temporizador de cuenta regresiva y llegó a cero
    if (timer.type === 'countdown' && timer.elapsedTime <= 0) {
        // Cambiar el color a rojo
        timer.display.style.backgroundColor = '#ff9999'; // Rojo claro
        
        // Reproducir el sonido de la alarma
        const alarmSound = new Audio('http://localhost/temporizador/assets/sounds/alarm.mp3');
        alarmSound.play().catch(error => {
            console.error('Error al reproducir el sonido:', error);
        });
        
        // Detener el temporizador para que no siga ejecutándose
        clearInterval(timer.timer);
    }
}
