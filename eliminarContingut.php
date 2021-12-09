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

    // Connexió a bd
    include "connection.php";

    // Primer de tot sa'han d'eliminar totes les files de missatge, contingutfavorits i de tipus_contingut que tenen associat l'idContingut que es vol eliminar
    $query="DELETE FROM missatge WHERE IdContingut=".$IdContingut;
    $result=mysqli_query($con, $query); echo $IdContingut;

    $query="DELETE FROM contingutfavorits WHERE IdContingut=".$IdContingut;
    $result=mysqli_query($con, $query); echo $IdContingut;

    $query="DELETE FROM r_tipus_contingut WHERE IdContingut=".$IdContingut;
    $result=mysqli_query($con, $query); echo $IdContingut;

    // Finalment eliminam el contingut de la taula contingut
    $query="DELETE FROM contingut WHERE IdContingut=".$IdContingut;
    echo $IdContingut;
    $result=mysqli_query($con, $query); 

    mysqli_close($con);

    if (!isset($row['username'])){
        header("Location: llistarContinguts.php?msg=1");
        die();
    }
?>