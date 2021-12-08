<?php session_start();

    if(isset($_SESSION['username'])){
        header("Location: login.php");
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"> <!-- Iconos bootstrap -->
    <script language="JavaScript" type="text/javascript" src="scripts.js"></script> <!-- Para importar mi hoja de scripts propia -->
</head>
    <body class>
        <header>
        <?php if (isset($_GET['msg'])){
            switch ($_GET['msg']) {
                case 1:
                    echo    '<div class="padding"></div><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi-person-x" style="font-size: 0.9rem;"></i>
                                &nbspEl username introducido no existe
                            </div>';
                    break;
                case 2:
                    echo    '<div class="padding"></div><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi-person-x" style="font-size: 0.9rem;"></i>
                                &nbspContraseña incorrecta
                            </div>';
                    break;
                case 3: 
                    echo    '<div class="padding"></div><div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi-person-x" style="font-size: 0.9rem;"></i>
                                &nbspTe has registrado satisfactoriamente
                            </div>';
                    default:
                }
        } ?>
            <h1 class="title-large">Pelistube</h1>
            <h2 class="subtitle-large">Tu plataforma de streaming</h2>
        </header>

        <section>
            <div class="container">
                <div class="row ">
                    <div class="col-md-4"></div> <!--primera columna vacía-->
                    <div class="col-md-4">
                        <div class="shadow-lg p-4 mb-5 bg-body rounded">   
                            <form action="login.php" method="post">
                                <div class="d-grid gap-2">
                                    <input name="username" class="form-control" placeholder="Usuario" required>
                                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                                    <button type="submit" class="btn btn-danger">Iniciar Sesión</button>
                                    <a class="btn btn-outline-danger" href="registerform.php" role="button">Regístrate</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer>
            PelisTube &copy; 2021
        </footer>

        <!-- Frameworks -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>    
</html>