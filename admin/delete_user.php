<?php
require '../config/config.php';
if(!isset($_SESSION['user']) || $_SESSION['user']['rol']!=='admin') {
    header('Location: ../public/login.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if($id === $_SESSION['user']['id']) {
    die('No puedes eliminar tu propio usuario.');
}

$db->query("DELETE FROM usuarios WHERE id=$id");
header('Location: users_admin.php');
exit;
