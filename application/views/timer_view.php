<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temporizadores Tarea UMG</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>
<body>
    <header>
        <h1>Conteo de Tiempo por equipos UMG</h1>
    </header>
    <main>

            <!-- Espacio para mostrar la temperatura -->
            <div id="weather">
             <p>Temperatura actual: <span id="currentTemperature">Cargando...</span> °C</p>
            </div>



        <div id="timersContainer">
            <!-- Espacio donde iran los temporizadores -->
        </div>
        
        <!-- espacio del formulario para agregar un temporizasor -->
        <div id="timerControls">
            <h2>Crea tu nuevo temporizador</h2>
            <label for="description">Descripción:</label>
            <input type="text" id="description" placeholder="Ingrese descripción">
            
            <label for="backgroundColor">Color de Fondo:</label>
            <select id="backgroundColor">
                <option value="#ffffff">Blanco</option>
                <option value="#99ff99">Verde</option>
                <option value="#9999ff">Azul </option>
                <option value="#ffff99">Amarillo</option>
                <option value="#ff99ff">Rosado</option>
                <option value="#cccccc">Gris </option>
            </select>
            
            <label for="timerType">Tipo de Temporizador:</label>
            <select id="timerType">
                <option value="countup">Cronómetro</option>
                <option value="countdown">Conteo Regresivo</option>
            </select>
            
            <div id="countdownOptions" style="display: none;">
                <label for="countdownTime">Tiempo (minutos):</label>
                <input type="number" id="countdownTime" min="1" placeholder="Ingrese minutos">
            </div>
            <button id="createTimerButton">Agregar Temporizador</button>
        </div>
    </main>
    <script src="<?php echo base_url('assets/js/timer.js'); ?>"></script>


    <!-- temperatura API -->
    <script>
    function getTemperature() {
        fetch("<?php echo base_url('weather/get_temperature'); ?>")
        .then(response => response.json())
        .then(data => {
            if (data.temperature) {
                document.getElementById('currentTemperature').textContent = data.temperature;
            } else {
                document.getElementById('currentTemperature').textContent = 'Error';
            }
        })
        .catch(error => {
            document.getElementById('currentTemperature').textContent = 'Error';
        });
    }

    // Llamar a la función 
    window.onload = getTemperature;
</script>
</body>
</html>
