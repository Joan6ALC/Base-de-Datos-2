<?php 
    
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: index.html");
        die();
    }

    include "connection.php";
    $Categoria = $_GET['categoria'];
    $username = $_SESSION['username'];

    $ConsultaContrato = "SELECT idContracte FROM contracte WHERE username = '".$username."'"; 
    $ResultadoContrato = mysqli_query($con, $ConsultaContrato);
    $idcontracte = mysqli_fetch_array($ResultadoContrato);

    $consulta = "SELECT nomCat FROM categoriafavorits WHERE idContracte = '".$idcontracte."'";
    $Resultado = mysqli_query($con, $consulta);

    while($Registre = mysqli_fetch_array($Resultado)){
        if($Categoria==$Registre['nomCat']){
            echo "La categoria ya esta dentro de la lista de favoritos";
            header("Location: login.php?");
            die();
        }
    }
    $insert = "INSERT into categoriafavorits (idContracte, nomCat) values ('".$idcontracte."','".$Categoria."')";
    mysqli_query($con, $insert);
    echo "Se ha añadido la categoria a favoritos";
    header("Location: login.php?");
    die();
?>