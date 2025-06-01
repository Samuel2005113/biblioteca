<?php
require '../config/config.php';
if(!isset($_SESSION['user']) || $_SESSION['user']['rol']!=='admin') {
  header('Location: ../public/login.php'); exit;
}
$res = $db->query("SELECT * FROM usuarios");
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Gestión de Usuarios</title><link rel="stylesheet" href="../public/css/styles.css"></head>
<body>
  <header><h1>Usuarios</h1></header>
  <div class="container">
    <a href="../public/index.php"><button>Volver</button></a>
    <a href="add_user.php"><button>Nuevo Usuario</button></a>
    <table class="table">
      <thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Acciones</th></tr></thead>
      <tbody>
      <?php while($u = $res->fetch_assoc()): ?>
        <tr>
          <td><?php echo $u['id']; ?></td>
          <td><?php echo htmlspecialchars($u['nombre']); ?></td>
          <td><?php echo htmlspecialchars($u['email']); ?></td>
          <td><?php echo $u['rol']; ?></td>
          <td>
            <a href="edit_user.php?id=<?php echo $u['id']; ?>">Editar</a> |
            <a href="delete_user.php?id=<?php echo $u['id']; ?>" onclick="return confirm('Seguro?')">Borrar</a>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>