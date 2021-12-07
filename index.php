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
    <body class>
        <header>
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
                                    <?php if (isset($_GET['error'])){
                                            switch ($_GET['error']) {
                                                case 1:
                                                    echo '<div class="error-message">El username introducido no existe</div>';
                                                    break;
                                                case 2:
                                                    echo '<div class="error-message">Contraseña incorrecta</div>';
                                                    break;
                                                default:
                                            }
                                        } ?>
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
    </body>
</html>