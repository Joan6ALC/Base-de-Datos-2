<?php 
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: index.php");
        die();
    }
     // Connexió a bd
    include "connection.php";

    $user = $_SESSION['username']; // Variable de sessió
    $name= $_POST['name'];
    $surname1= $_POST['surname1'];
    $surname2= $_POST['surname2'];
    $dob = $_POST['dateofbirth'];
    $username = $_POST['username'];
    $password1 = $_POST['password'];
    $password2 = $_POST['password2'];
    
    // Comprovam que les contrasenyes introduides coincideixen
    if($password1!=$password2){ // Si coincideixen, error 1
        header("Location: editarUsuariForm.php?error=1&name=$name&surname1=$surname1&surname2=$surname2&dob=$dob&username=$username");
        die();
    }

    $hash=crypt($password1,"");

    //echo $user." ";
    //echo $username;

    $seleccio = "select username from persona where username = '".$username."'";
    $resultado = mysqli_query($con,$seleccio);
    $registro = mysqli_fetch_array($resultado);

    if($user == $username){ // Si el username es manté igual, només actualitz la resta d'atributs
        $query = "update persona set password ='".$hash."', nom ='".$name."', llinatge1 ='".$surname1."', llinatge2 ='".$surname2."', dataNaixament ='".$dob."'  where username ='".$user."'";
        
    }else{ // L'username canvia, anem a mirar si el nou username és vàlid (no està encara utilitzat)
        // CONSULTES SQL per comprovar si l'username existeix a la bd
        if ($registro != $username){
            // podem actualitzar l'username antic pel nou i la resta de parámetres
            $query = "update persona set username ='".$username."', password ='".$hash."', nom ='".$name."', llinatge1 ='".$surname1."', llinatge2 ='".$surname2."', dataNaixament ='".$dob."'  where username ='".$user."'";
        } else {
            // mostrar missatge d'error: l'username ja esta essent utilitzat
            header("Location: editarUsuariForm.php?error=2&name=$name&surname1=$surname1&surname2=$surname2&dob=$dob&username=$username");
            die();
        }
    }

    mysqli_query($con, $query);
    $_SESSION['username'] = "'.$username.'";

    if (isset($_SESSION['username'])){ 
        header("Location: index.php");
        session_destroy();
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
            <?php include "navbar.php"; ?>
        </header>
        <!-- Frameworks -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>
