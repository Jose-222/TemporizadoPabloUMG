<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $restriccion_tiempo = $_POST['restriccion_tiempo'];

    $stmt = $pdo->prepare("INSERT INTO categorias (nombre, descripcion, restriccion_tiempo) VALUES (?, ?, ?)");
    $stmt->execute([$nombre, $descripcion, $restriccion_tiempo]);

    echo "Categoría creada.";
}
?>
<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="text" name="descripcion" placeholder="Descripción">
    <input type="number" name="restriccion_tiempo" placeholder="Restricción (minutos)">
    <button type="submit">Crear</button>
</form>
