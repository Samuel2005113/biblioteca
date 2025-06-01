<?php
require '../config/config.php';
if(!isset($_SESSION['user'])) { header('Location: login.php'); exit; }
$res = $db->query("SELECT * FROM libros WHERE ejemplares_disponibles>0");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Catálogo Público</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <header><h1>Catálogo de Libros</h1></header>
  <div class="container">
    <?php while($lib = $res->fetch_assoc()): ?>
      <div style="border-bottom:1px solid #ddd;padding:1rem 0;">
        <h3><?php echo htmlspecialchars($lib['titulo']); ?></h3>
        <p>Autor: <?php echo htmlspecialchars($lib['autor']); ?></p>
        <p>Disponibles: <?php echo $lib['ejemplares_disponibles']; ?></p>
        <a href="../reservations/reserve.php?id=<?php echo $lib['id']; ?>"><button>Reservar</button></a>
      </div>
    <?php endwhile; ?>
    <a href="index.php"><button>Volver</button></a>
  </div>
</body>
</html>