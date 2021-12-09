<?php session_start();

    if(!isset($_SESSION['username'])){
        header("Location: login.php");
        die();
    }
    include "connection.php";
    $IdContingut=$_GET['id'];
    $redirect = $_GET['redir'];

    $query="DELETE FROM contingutfavorits WHERE IdContingut=".$IdContingut." AND IdContracte=".$_SESSION['IdContracte']." ";
    $result=mysqli_query($con, $query);
    header("Location: $redirect");

    mysqli_close($con);
?>