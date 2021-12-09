<?php 
    
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: index.html");
        die();
    }

    include "connection.php";
    $Contingut = $_GET['id'];

    if(isset($_SESSION['IdContracte'])){
    $insert = "INSERT into ContingutFavorits (IdContracte, IdContingut) VALUES ('".$_SESSION['IdContracte']."','".$Contingut."')";
    mysqli_query($con, $insert);
    }

mysqli_close($con);
header("Location: llistarCategories.php");
die();

    
?>