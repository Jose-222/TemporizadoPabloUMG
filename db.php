<?php
$host = 'localhost';
$db = 'nombre_de_tu_bd';
$user = 'usuario';
$pass = 'contraseña';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
