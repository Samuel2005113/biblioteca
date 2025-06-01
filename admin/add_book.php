<?php
require '../config/config.php';
if(!isset($_SESSION['user']) || $_SESSION['user']['rol']!=='admin') {
    header('Location: ../public/login.php');
    exit;
}

if($_POST) {
    $titulo = $db->real_escape_string($_POST['titulo']);
    $autor  = $db->real_escape_string($_POST['autor']);
    $isbn   = $db->real_escape_string($_POST['isbn']);
    $total  = (int)$_POST['ejemplares_totales'];
    $db->query(
      "INSERT INTO libros (titulo, autor, isbn, ejemplares_totales, ejemplares_disponibles)
       VALUES('$titulo','$autor','$isbn',$total,$total)"
    );
    header('Location: books_admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Nuevo Libro</title>
  <link rel="stylesheet" href="../public/css/styles.css">
</head>
<body>
  <header><h1>Agregar Libro</h1></header>
  <div class="container">
    <form method="post">
      <label>Título:</label>
      <input name="titulo" type="text" required>
      <label>Autor:</label>
      <input name="autor" type="text" required>
      <label>ISBN:</label>
      <input name="isbn" type="text" required>
      <label>Ejemplares Totales:</label>
      <input name="ejemplares_totales" type="number" min="1" value="1" required>
      <button type="submit">Guardar</button>
    </form>
    <a href="books_admin.php"><button>Cancelar</button></a>
  </div>
</body>
</html>
