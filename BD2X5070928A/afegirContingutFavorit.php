<?php 
    
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: index.html");
        die();
    }

    include "connection.php";
    $Contingut = $_GET['id'];
    $nomCat = $_GET['nomCat'];
    $redirect = $_GET['redir'];
    $aux = "llistaContingutCat.php";

    if(isset($_SESSION['IdContracte'])){
    $insert = "INSERT into ContingutFavorits (IdContracte, IdContingut) VALUES ('".$_SESSION['IdContracte']."','".$Contingut."')";
    mysqli_query($con, $insert);
    }

mysqli_close($con);
if(strcmp($redirect, $aux)==0){
    header("Location: $redirect?msg=8&id=$nomCat");
}else{
    header("Location: $redirect?msg=8&id=$Contingut");
}

die();

    
?>