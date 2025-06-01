<?php
require '../config/config.php';
if(!isset($_SESSION['user'])) {
    header('Location: login.php'); exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Biblioteca - Inicio</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <header>
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['user']['nombre']); ?></h1>
  </header>
  <div class="container">
    <?php if($_SESSION['user']['rol']==='admin'): ?>
      <a href="../admin/user_admin.php"><button>Gestionar Usuarios</button></a>
      <a href="../admin/books_admin.php"><button>Gestionar Libros</button></a>
    <?php endif; ?>
    <a href="books_public.php"><button>Ver Catálogo</button></a>
    <a href="logout.php"><button>Salir</button></a>
  </div>
</body>
</html>