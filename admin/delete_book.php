<?php
require '../config/config.php';
if(!isset($_SESSION['user']) || $_SESSION['user']['rol']!=='admin') header('Location: ../public/login.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$db->query("DELETE FROM libros WHERE id=$id");
header('Location: books_admin.php'); exit;