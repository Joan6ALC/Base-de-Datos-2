<?php session_start();

    if(!isset($_SESSION['username'])){
        header("Location: login.php");
        die();
    }

    if($_SESSION['administrador']!=1){
        header("Location: login.php");
        die();
    }

    $IdContingut=$_GET['id'];
    $Redirect=$_GET['redir'];

    // Connexió a bd
    include "connection.php";


    // Fem invisible el contingut
    $query="UPDATE contingut SET visible=1 WHERE IdContingut=".$IdContingut;
    $result=mysqli_query($con, $query);

    mysqli_close($con);

    if (!isset($row['username'])){
        header("Location: $Redirect?msg=1");
        die();
    }
?>