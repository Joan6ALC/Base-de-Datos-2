<?php 
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: index.php");
        die();
    }
     // Connexió a bd
    include "connection.php";
    
    //assignem les variables donades per l'usuari a unes variables locals
    $estado = $_POST['entrada1'];
    $tarifa = $_POST['entrada2'];
    $user = $_SESSION['username'];
    //per obtenir la data actual
    $localdate = date('y-m-d');
    //variable per a establir que una data pot ser null
    $notdate = null;
    //si no hi ha cap contracte realitzat, realitzem un insert a la base de dades amb l'estat i la
    //tarifa seleccionades per l'usuari, la data d'alta serà la local i la de baixa serà null
    if($_SESSION['IdContracte'] == null){
        $query = "INSERT INTO contracte(dataAlta,dataBaixa,estat,nomTarifa,username) VALUES ('".$localdate."', '".$notdate."','".$estado."', '".$tarifa."','".$user."')";
        mysqli_query($con, $query);
        //select per a agafar l'id del nou contracte creat i poder ficar-ho a la variable global 
        $_SESSION['estatContracte'] = $estado;
        $comprovacio = "SELECT IdContracte FROM contracte where username = '".$user."'";
        $aplicacio = mysqli_query($con, $comprovacio);
        $valor = mysqli_fetch_array($aplicacio);
        $_SESSION['IdContracte'] = $valor['IdContracte'];
        
        $tar = "SELECT * FROM tarifa WHERE nomTarifa = '".$tarifa."'";
        $ResultatTarifa = mysqli_query($con, $tar);
        $ValorTarifa = mysqli_fetch_array($ResultatTarifa);
        $fecha = strval($ValorTarifa['periodicitat']);
        $date1 = date("y-m-d", strtotime($localdate."+ $fecha days"));
        $query2 = "INSERT INTO factura(dataInici, import, dataFinal, IdContracte) VALUES ('".$localdate."','".$ValorTarifa['preu']."','".$date1."','".$_SESSION['IdContracte']."')";
        $PrimeraFac = mysqli_query($con, $query2);
        // Redirigim a l'usuari a la pàgina principal
        header("Location: login.php?msg=11");
        die();

    }else{
        //si ja tenia un contracte creat, mirem l'estat al qual volem canviar
        if($estado == 1){
            //cas de voler activar el contracte, la data d'alta passa a ser l'actual i no hi ha data de baixa
            $query = "update contracte set dataAlta = '".$localdate."', dataBaixa = '".$notdate."',estat ='".$estado."', nomTarifa ='".$tarifa."' WHERE username = '".$user."'";
        }elseif($estado == 0){
            //cas de voler desactivar el contracte, la data de baixa és la data actual
            $query = "update contracte set dataBaixa = '".$localdate."',estat ='".$estado."', nomTarifa ='".$tarifa."' WHERE username = '".$user."'";
        }
        $_SESSION['estatContracte'] = $estado;
        mysqli_query($con, $query);
        // Redirigim a l'usuari a la pàgina principal
        header("Location: login.php?msg=12");
        die();
    }
    
    
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
            <?php include "navbar.php"; 
            include "missatge.php";?>
        </header>
        <!-- Frameworks -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>