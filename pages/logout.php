<?php
require_once '../classes/User.php';

// Démarrer la session et se déconnecter
session_start();
session_unset();
session_destroy();

// Redirection vers la page de connexion
header("Location: /login.php");
exit();
?>
