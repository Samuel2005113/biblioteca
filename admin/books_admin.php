<?php
require '../config/config.php';
if(!isset($_SESSION['user']) || $_SESSION['user']['rol']!=='admin') {
    header('Location: ../public/login.php');
    exit;
}
$res = $db->query("SELECT * FROM libros");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Libros</title>
  <link rel="stylesheet" href="../public/css/styles.css">
</head>
<body>
  <header><h1>Libros</h1></header>
  <div class="container">
    <a href="../public/index.php"><button>Volver</button></a>
    <a href="add_book.php"><button>Nuevo Libro</button></a>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th><th>Título</th><th>Autor</th>
          <th>ISBN</th><th>Total</th><th>Disponibles</th><th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php while($lib = $res->fetch_assoc()): ?>
        <tr>
          <td><?php echo $lib['id']; ?></td>
          <td><?php echo htmlspecialchars($lib['titulo']); ?></td>
          <td><?php echo htmlspecialchars($lib['autor']); ?></td>
          <td><?php echo htmlspecialchars($lib['isbn']); ?></td>
          <td><?php echo $lib['ejemplares_totales']; ?></td>
          <td><?php echo $lib['ejemplares_disponibles']; ?></td>
          <td>
            <a href="edit_book.php?id=<?php echo $lib['id']; ?>">Editar</a> |
            <a href="delete_book.php?id=<?php echo $lib['id']; ?>" onclick="return confirm('¿Borrar este libro?')">Borrar</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
