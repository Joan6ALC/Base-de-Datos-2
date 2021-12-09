<?php session_start();

    if(!isset($_SESSION['username'])){
        header("Location: login.php");
        die();
    }
    include "connection.php";
    $Categoria=$_GET['id'];
    $redirect = $_GET['redir'];

    $query="DELETE FROM categoriafavorits WHERE nomCat='".$Categoria."' AND IdContracte='".$_SESSION['IdContracte']."'";
    $result=mysqli_query($con, $query);
    header("Location: llistarCategories.php?msg=1");

    mysqli_close($con);
?>