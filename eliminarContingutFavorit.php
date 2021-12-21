<?php session_start();

    if(!isset($_SESSION['username'])){
        header("Location: login.php");
        die();
    }
    include "connection.php";
    $IdContingut=$_GET['id'];
    $nomCat = $_GET['nomCat'];
    $redirect = $_GET['redir'];
    $aux = "llistaContingutCat.php";

    $query="DELETE FROM contingutfavorits WHERE IdContingut=".$IdContingut." AND IdContracte=".$_SESSION['IdContracte']." ";
    $result=mysqli_query($con, $query);
    if(strcmp($redirect, $aux)==0){
        header("Location: $redirect?msg=9&id=$nomCat");
    }else{
        header("Location: $redirect?msg=9&id=$Contingut");
    }

    mysqli_close($con);
?>