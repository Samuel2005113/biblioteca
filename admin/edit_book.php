<?php
require '../config/config.php';
if(!isset($_SESSION['user']) || $_SESSION['user']['rol']!=='admin') header('Location: ../public/login.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if($_POST) {
    $titulo = $db->real_escape_string($_POST['titulo']);
    $autor = $db->real_escape_string($_POST['autor']);
    $isbn = $db->real_escape_string($_POST['isbn']);
    $total = (int)$_POST['ejemplares_totales'];
    $libro = $db->query("SELECT ejemplares_totales, ejemplares_disponibles FROM libros WHERE id=$id")->fetch_assoc();
    $diff = $total - $libro['ejemplares_totales'];
    $db->query("UPDATE libros SET titulo='$titulo', autor='$autor', isbn='$isbn', ejemplares_totales=$total, ejemplares_disponibles=ejemplares_disponibles + $diff WHERE id=$id");
    header('Location: books_admin.php'); exit;
}
$res = $db->query("SELECT * FROM libros WHERE id=$id");
if(!$res || !$libro = $res->fetch_assoc()) die('Libro no encontrado');
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Editar Libro</title><link rel="stylesheet" href="../public/css/styles.css"></head>
<body>
  <header><h1>Editar Libro</h1></header>
  <div class="container">
    <form method="post">
      <label>Título:</label>
      <input name="titulo" type="text" value="<?php echo htmlspecialchars($libro['titulo']); ?>" required>
      <label>Autor:</label>
      <input name="autor" type="text" value="<?php echo htmlspecialchars($libro['autor']); ?>" required>
      <label>ISBN:</label>
      <input name="isbn" type="text" value="<?php echo htmlspecialchars($libro['isbn']); ?>" required>
      <label>Ejemplares Totales:</label>
      <input name="ejemplares_totales" type="number" min="1" value="<?php echo $libro['ejemplares_totales']; ?>" required>
      <button type="submit">Guardar</button>
    </form>
    <a href="books_admin.php"><button>Cancelar</button></a>
  </div>
</body>
</html>