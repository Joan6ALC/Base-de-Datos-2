<?php session_start();

    if(!isset($_SESSION['username'])){
        header("Location: login.php");
        die();
    }

    if($_SESSION['administrador']!=1){
        header("Location: login.php");
        die();
    }

    echo $_SESSION['username']." ";
    echo  $_SESSION['administrador'];







?>