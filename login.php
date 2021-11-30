<?php session_start();

if (isset($_SESSION)) {
    echo "Sesión no iniciada";
    // Recollida de paràmetres
    $username= $_POST['username'];
    $password= $_POST['password'];

    // Connexió a bd
    include "conexion.php";
    $consulta = "SELECT * FROM persona where username='".$username."'";

    $resultado=mysqli_query($con, $consulta); // hay que comprobar si el username existe --> resultado!=null ¿?¿?¿?¿
    $registro = mysqli_fetch_array($resultado);

    $passbd = $registro['password']; // Contiene la contraseña encriptada que esta guardada en la bd

    if(!password_verify($password, $passbd)){ // Compara la contraseña introducida (plana) con la guardada en la base de datos (hash)
        echo "<br> ERROR: PASSWORD NO CORRECTO"; // Cómo muestro un html diferente si se produce este error?????
    
    } else {
        echo "<br> PASSWORD CORRECTO";
        $_SESSION['username']= $username;
    }
}
// Mostrar menú d'opcions
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
            <h1 class="title-large">Pelistube</h1>
            <h2 class="subtitle-large">Tu plataforma de streaming</h2>
        </header>

        <section>
            <center>
                 
                
            </center>
        </section>


        <footer>
            PelisTube &copy; 2021
        </footer>
    </body>
</html>
