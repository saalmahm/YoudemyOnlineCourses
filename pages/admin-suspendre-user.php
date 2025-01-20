<?php
require_once '../db.php';
require_once '../classes/User.php';
require_once '../classes/Administrateur.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $admin = new Administrateur($conn, $_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_password']);
    $admin->suspendreUser($userId);

    header("Location: admin-listUsers.php");
    exit();
} else {
    echo "ID d'utilisateur manquant.";
}
?>
