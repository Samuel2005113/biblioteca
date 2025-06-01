<?php
session_start();
$db = new mysqli('localhost','root','', 'biblioteca');
if($db->connect_errno) {
    die("Error de conexión BD: " . $db->connect_error);
}