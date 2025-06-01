<?php
require '../config/config.php';
if(!isset($_SESSION['user']) || $_SESSION['user']['rol']!=='admin') {
    header('Location: ../public/login.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($_POST) {
    $nombre = $db->real_escape_string($_POST['nombre']);
    $email  = $db->real_escape_string($_POST['email']);
    $rol    = ($_POST['rol'] === 'admin' ? 'admin' : 'usuario');
    if(!empty($_POST['password'])) {
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $db->query(
          "UPDATE usuarios
           SET nombre='$nombre', email='$email', rol='$rol', password_hash='$pass'
           WHERE id=$id"
        );
    } else {
        $db->query(
          "UPDATE usuarios
           SET nombre='$nombre', email='$email', rol='$rol'
           WHERE id=$id"
        );
    }
    header('Location: users_admin.php');
    exit;
}

// Obtener datos actuales
$res = $db->query("SELECT nombre,email,rol FROM usuarios WHERE id=$id");
if(!$res || !($user = $res->fetch_assoc())) {
    die('Usuario no encontrado');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Usuario</title>
  <link rel="stylesheet" href="../public/css/styles.css">
</head>
<body>
  <header><h1>Editar Usuario</h1></header>
  <div class="container">
    <form method="post">
      <label>Nombre:</label>
      <input name="nombre" type="text" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
      <label>Email:</label>
      <input name="email" type="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
      <label>Rol:</label>
      <select name="rol">
        <option value="usuario" <?php if($user['rol']==='usuario') echo 'selected'; ?>>Usuario</option>
        <option value="admin" <?php if($user['rol']==='admin') echo 'selected'; ?>>Admin</option>
      </select>
      <label>Contraseña (dejar en blanco para no cambiar):</label>
      <input name="password" type="password">
      <button type="submit">Guardar</button>
    </form>
    <a href="user_admin.php"><button>Cancelar</button></a>
  </div>
</body>
</html>
