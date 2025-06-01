<?php
require '../config/config.php';
if(!isset($_SESSION['user'])) {
    header('Location: ../public/login.php');
    exit;
}
$stmt = $db->prepare(
    "SELECT r.id, l.titulo, l.autor, r.fecha_reserva, r.fecha_devolucion, l.id as libro_id
     FROM reservas r
     JOIN libros l ON r.libro_id = l.id
     WHERE r.usuario_id = ?"
);
$stmt->bind_param('i', $_SESSION['user']['id']);
$stmt->execute();
$res = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mis Reservas</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <header><h1>Mis Reservas</h1></header>
  <div class="container">
    <a href="../public/index.php"><button>Volver</button></a>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Título</th>
          <th>Autor</th>
          <th>Fecha Reserva</th>
          <th>Fecha Devolución</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
      <?php while($row = $res->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo htmlspecialchars($row['titulo']); ?></td>
          <td><?php echo htmlspecialchars($row['autor']); ?></td>
          <td><?php echo $row['fecha_reserva']; ?></td>
          <td><?php echo $row['fecha_devolucion'] ?? '-'; ?></td>
          <td>
            <?php if(!$row['fecha_devolucion']): ?>
              <a href="mis_reservas.php?devolver=<?php echo $row['id']; ?>" onclick="return confirm('Confirmar devolución?')">Devolver</a>
            <?php else: ?>
              —
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
    <?php
    // esto de aqui es la logica de la devolucion de libros basicamente
    if(isset($_GET['devolver'])) {
        $reserva_id = (int)$_GET['devolver'];
        $stmt2 = $db->prepare("SELECT libro_id FROM reservas WHERE id = ? AND usuario_id = ?");
        $stmt2->bind_param('ii', $reserva_id, $_SESSION['user']['id']);
        $stmt2->execute();
        $stmt2->bind_result($libro_id);
        if($stmt2->fetch()) {
            $stmt2->close();
            $stmt3 = $db->prepare(
                "UPDATE reservas SET fecha_devolucion = NOW() WHERE id = ?"
            );
            $stmt3->bind_param('i', $reserva_id);
            $stmt3->execute();
            $stmt3->close();
            $stmt4 = $db->prepare(
                "UPDATE libros SET ejemplares_disponibles = ejemplares_disponibles + 1 WHERE id = ?"
            );
            $stmt4->bind_param('i', $libro_id);
            $stmt4->execute();
            $stmt4->close();
            header('Location: mis_reservas.php');
            exit;
        }
        $stmt2->close();
    }
    ?>
  </div>
</body>
</html>