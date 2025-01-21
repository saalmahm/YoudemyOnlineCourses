<?php
require_once '../classes/User.php';

session_start();
session_unset();
session_destroy();

header("Location: /login.php");
exit();
?>
