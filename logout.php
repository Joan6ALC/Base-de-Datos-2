<?php 
    session_start(); // Dins aquesta sessió
    session_destroy(); // La tancam
    header("Location: index.php");
    die();
?>