<?php
include 'db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM categorias WHERE id = ?");
$stmt->execute([$id]);
$categoria = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $restriccion_tiempo = $_POST['restriccion_tiempo'];

    $stmt = $pdo->prepare("UPDATE categorias SET nombre = ?, descripcion = ?, restriccion_tiempo = ? WHERE id = ?");
    $stmt->execute([$nombre, $descripcion, $restriccion_tiempo, $id]);

    echo "Categoría actualizada.";
}
?>
<form method="POST">
    <input type="text" name="nombre" value="<?php echo $categoria['nombre']; ?>" required>
    <input type="text" name="descripcion" value="<?php echo $categoria['descripcion']; ?>">
    <input type="number" name="restriccion_tiempo" value="<?php echo $categoria['restriccion_tiempo']; ?>">
    <button type="submit">Actualizar</button>
</form>
