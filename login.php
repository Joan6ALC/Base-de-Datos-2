<?php session_start();

if (isset($_SESSION)) {
   // echo "Sesión no iniciada";
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
       // echo "<br> ERROR: PASSWORD NO CORRECTO"; // Cómo muestro un html diferente si se produce este error?????
    
    } else {
        //echo "<br> PASSWORD CORRECTO";
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
            <div class="col-12">
                <nav class="navbar navbar-expand-md navbar-light border-2 border-bottom border-danger" style="background-color: #FFFFFF;">
                    <div class="container-fluid">
                        <a href="#" class="navbar-brand">
                            <img src="img/navbar_logo.png" width="100" height="30">
                        </a>
                        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#MenuNavegacion">
                            <span class="navbar-toggler-icon"></span> <!-- Icono desplegable para dispositivos pequeños -->
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavDropdown">
                            <div id="MenuNavegacion" class="collapse navbar-collapse">
                            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                            <div id="MenuNavegacion" class="collapse navbar-collapse">
                                <ul class="navbar-nav ms-3">
                                    <li class="nav-item"><a class="nav-link" href="#">Explorar</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#">Categorías</a></li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Favoritos
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            <a class="dropdown-item" href="#">Contenidos</a>
                                            <a class="dropdown-item" href="#">Categorias</a>
                                        </div>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Perfil
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            <a class="dropdown-item" href="#">Ver perfil</a>
                                            <a class="dropdown-item" href="#">Editar perfil</a>
                                            <a class="dropdown-item" href="#">Contenidos favoritos</a>
                                            <a class="dropdown-item" href="#">Categorias favoritas</a>
                                            <a class="dropdown-item" href="#">Mensajes</a>
                                            <a class="dropdown-item" href="#">Facturas</a>
                                        </div>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" href="#">Cerrar sesión</a></li>
                                </ul>
                            </div>
                        </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <section>
            <div class="container">
                <div class="row ">
                    <div class="col-md-1"></div> <!--primera columna vacía-->
                    <div class="col-md-10">
                        <div class="shadow-lg p-4 mb-5 bg-body rounded">
                            <div class="d-grid gap-1">
                                <div class="align-center">
                                <center>Bienvenido de nuevo<br></center>
                                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <footer>
            PelisTube &copy; 2021
        </footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>
