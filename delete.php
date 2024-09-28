<?php
include 'db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM categorias WHERE id = ?");
$stmt->execute([$id]);

echo "Categoría eliminada.";
?>
