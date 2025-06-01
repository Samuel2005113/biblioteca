<?php
require '../config/config.php';
$message = '';
if($_POST) {
    $email = $db->real_escape_string($_POST['email']);
    $res = $db->query("SELECT * FROM usuarios WHERE email='$email'");
    if($res && $user = $res->fetch_assoc()) {
        if(password_verify($_POST['password'], $user['password_hash'])) {
            $_SESSION['user'] = $user;
            header('Location: index.php'); exit;
        }
    }
    $message = 'Credenciales inválidas';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <header><h1>Acceder</h1></header>
  <div class="container">
    <?php if($message): ?><p><?php echo $message; ?></p><?php endif; ?>
    <form method="post">
      <label>Email:</label>
      <input name="email" type="email" required>
      <label>Contraseña:</label>
      <input name="password" type="password" required>
      <button type="submit">Entrar</button>
    </form>
    <p>¿No tienes cuenta? <a href="register.php">Regístrate</a></p>
  </div>
</body>
</html>