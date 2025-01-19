<?php

require_once '../db.php'; 
require_once '../classes/User.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    try {
        $result = User::créeCompte($conn, $nom, $email, $role, $password);

        if($result === true) {
            header("Location: login.php"); 
            exit();
        } else {
            $errorMessage = $result;
            echo $errorMessage; 
        }
    } catch (Exception $e) {
        $errorMessage = "Une erreur s'est produite : " . $e->getMessage();
        echo $errorMessage; 
    }
}
