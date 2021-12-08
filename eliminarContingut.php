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



    // Connexió a bd
    include "connection.php";
    $query = "SELECT * FROM persona WHERE username='".$_SESSION['username']."'";
    $result=mysqli_query($con, $query); 
    $row = mysqli_fetch_array($result);

?>