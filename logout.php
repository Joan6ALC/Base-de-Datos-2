<?php 
    session_start(); // Dins aquesta sessió
    session_destroy(); // La tancam
    //$URL="index.html";
    header("Location: index.html");
    die();
?>