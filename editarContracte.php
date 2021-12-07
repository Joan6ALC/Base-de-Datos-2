<?php 
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: index.php");
        die();
    }
     // Connexió a bd
    include "connection.php";
    
    $estado = $_POST['entrada1'];
    $tarifa = $_POST['entrada2'];
    $user = $_SESSION['username'];
    $localdate = date('y-m-d');
    $notdate = null;
    if($estado == 1){
        $query = "update contracte set dataAlta = '".$localdate."', dataBaixa = '".$notdate."',estat ='".$estado."', nomTarifa ='".$tarifa."' WHERE username = '".$user."'";
    }elseif($estado == 0){
        $query = "update contracte set dataBaixa = '".$localdate."',estat ='".$estado."', nomTarifa ='".$tarifa."' WHERE username = '".$user."'";
    }
    
    mysqli_query($con, $query);
    header("Location: login.php?username=$username&estado=$estado&nomTarifa=$tarifa"); // Redirigim a l'usuari a la pàgina principal
    die();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width">
    <title>PelisTube - Tu plataforma de streaming</title> <!--Título que aparecerá en la pestaña del navegador-->
    <link rel="stylesheet" href="css/bootstrap.min.css"/> <!-- Importamos hoja de estilos de bootrstrap-->
    <link rel="stylesheet" href="styles.css"/> <!-- Nuestra propia hoja de estilos-->
    <link rel="shortcut icon" href="img/icon.png" /> <!-- Icono de la pestaña-->
</head>
    <body>
        <header>
            <?php include "navbar.php"; ?>
        </header>
        <!-- Frameworks -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>