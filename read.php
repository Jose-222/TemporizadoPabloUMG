<?php
include 'db.php';

$stmt = $pdo->query("SELECT * FROM categorias");
$categorias = $stmt->fetchAll();

foreach ($categorias as $categoria) {
    echo $categoria['nombre'] . " - " . $categoria['descripcion'] . " - " . $categoria['restriccion_tiempo'] . " minutos<br>";
}
?>
