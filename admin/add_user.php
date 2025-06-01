<?php
require '../config/config.php';
if(!isset($_SESSION['user']) || $_SESSION['user']['rol']!=='admin') {
    header('Location: ../public/login.php');
    exit;
}

$message = '';
if($_POST) {
    $nombre = $db->real_escape_string($_POST['nombre']);
    $email  = $db->real_escape_string($_POST['email']);
    $pass   = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $rol    = ($_POST['rol'] === 'admin' ? 'admin' : 'usuario');

    $sql = $db->prepare(
      "INSERT INTO usuarios (nombre, email, password_hash, rol)
       VALUES (?, ?, ?, ?)"
    );
    $sql->bind_param('ssss', $nombre, $email, $pass, $rol);
    if($sql->execute()) {
        header('Location: users_admin.php');
        exit;
    } else {
        $message = 'Error al crear el usuario: ' . $db->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Nuevo Usuario</title>
  <link rel="stylesheet" href="../public/css/styles.css">
</head>
<body>
  <header><h1>Agregar Usuario</h1></header>
  <div class="container">
    <?php if($message): ?><p style="color:red;"><?php echo $message; ?></p><?php endif; ?>
    <form method="post">
      <label>Nombre:</label>
      <input name="nombre" type="text" required>

      <label>Email:</label>
      <input name="email" type="email" required>

      <label>Contraseña:</label>
      <input name="password" type="password" required>

      <label>Rol:</label>
      <select name="rol">
        <option value="usuario">Usuario</option>
        <option value="admin">Admin</option>
      </select>

      <button type="submit">Crear Usuario</button>
    </form>
    <a href="user_admin.php"><button>Cancelar</button></a>
  </div>
</body>
</html>
