<?php
require '../config/config.php';
if($_POST) {
    $nombre = $db->real_escape_string($_POST['nombre']);
    $email  = $db->real_escape_string($_POST['email']);
    $pass   = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $db->query("INSERT INTO usuarios (nombre,email,password_hash) VALUES('$nombre','$email','$pass')");
    header('Location: login.php'); exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <header><h1>Registro</h1></header>
  <div class="container">
    <form method="post">
      <label>Nombre:</label>
      <input name="nombre" type="text" required>
      <label>Email:</label>
      <input name="email" type="email" required>
      <label>Contraseña:</label>
      <input name="password" type="password" required>
      <button type="submit">Registrar</button>
    </form>
    <p>¿Tienes cuenta? <a href="login.php">Entrar</a></p>
  </div>
</body>
</html>