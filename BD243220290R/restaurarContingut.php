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

    // Miram si la categoría ha estat invisibilitzada o no
    $query="SELECT categoria.visible FROM contingut JOIN categoria ON contingut.nomCat=categoria.nomCat AND IdContingut=".$IdContingut;
    $result=mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);

    // Fem visible el contingut
    $query="UPDATE contingut SET visible=1 WHERE IdContingut=".$IdContingut;
    $result=mysqli_query($con, $query);

    mysqli_close($con);

    if($row['visible']!=1){ // Si no pertany a una categoria visible
        header("Location: $Redirect?msg=20");
        die();
    } 
    
    header("Location: $Redirect?msg=10");
    die();
?>