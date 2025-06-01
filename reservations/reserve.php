<?php
require '../config/config.php';
if(!isset($_SESSION['user'])) {
    header('Location: ../public/login.php');
    exit;
}
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $db->prepare("SELECT ejemplares_disponibles FROM libros WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($disponibles);
if(!$stmt->fetch() || $disponibles < 1) {
    $stmt->close();
    die('El libro no está disponible para reserva.');
}
$stmt->close();
$stmt = $db->prepare("INSERT INTO reservas (usuario_id, libro_id) VALUES (?, ?)");
$stmt->bind_param('ii', $_SESSION['user']['id'], $id);
$stmt->execute();
$stmt->close();
$stmt = $db->prepare(
    "UPDATE libros SET ejemplares_disponibles = ejemplares_disponibles - 1 WHERE id = ?"
);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->close();
header('Location: mis_reservas.php');
exit;