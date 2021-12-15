<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width">
    <title>PelisTube - Tu plataforma de streaming</title> <!--Título que aparecerá en la pestaña del navegador-->
    <link rel="stylesheet" href="css/bootstrap.min.css"/> <!-- Importamos hoja de estilos de bootrstrap-->
    <link rel="stylesheet" href="styles.css"/> <!-- Nuestra propia hoja de estilos-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"> <!-- Iconos bootstrap -->
    <link rel="shortcut icon" href="img/icon.png" /> <!-- Icono de la pestaña-->
    <script language="JavaScript" type="text/javascript" src="scripts.js"></script> <!-- Para importar mi hoja de scripts propia -->
</head>
    <body>
        <header>
        <?php if (isset($_GET['error'])){
            switch ($_GET['error']) {
                case 1:
                    echo    '<div class="padding"></div><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi-person-x" style="font-size: 0.9rem;"></i>
                                &nbspLas contraseñas no coinciden
                            </div>';
                    break;
                case 2:
                    echo    '<div class="padding"></div><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi-person-x" style="font-size: 0.9rem;"></i>
                                &nbspEl nombre de usuario elegido ya existe
                            </div>';
                    break;
                default:
                }
        } ?>
            <h1 class="title-small">Pelistube</h1>
            <h2 class="subtitle-small">Tu plataforma de streaming</h2>
        </header>

        <section> 
            <div class="container">
                <div class="row ">
                    <div class="col-md-3"></div> <!--primera columna vacía-->
                    <div class="col-md-6">
                        <div class="shadow-lg p-4 mb-5 bg-body rounded">
                            <form action="register.php" method="post">
                                <div class="d-grid gap-2">
                                    <label>Nombre<span style="color: red;">*</span>:</label>
                                    <input name="name" class="form-control" placeholder="Nombre" <?php if(isset($_GET['name'])) echo 'value="'.$_GET['name'].'"'; ?>required>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Primer apellido<span style="color: red;">*</span>:</label>
                                            <input name="surname1" class="form-control" placeholder="Primer apellido" <?php if(isset($_GET['surname1'])) echo 'value="'.$_GET['surname1'].'"'; ?> required>
                                        </div> 
                                        <div class="col-md-6">
                                            <label>Segundo apellido:</label>
                                            <input name="surname2" class="form-control" placeholder="Segundo apellido" <?php if(isset($_GET['surname2'])) echo 'value="'.$_GET['surname2'].'"'; ?>>       
                                        </div> 
                                    </div>
                                    <label>Fecha de nacimiento<span style="color: red;">*</span>:</label>
                                    <input type="date" name="dateofbirth" class="form-control" min="1920-1-01" max="2023-12-31" <?php if(isset($_GET['dob'])) echo 'value="'.$_GET['dob'].'"'; ?> required>
                                    <label>Usuario<span style="color: red;">*</span>:</label>
                                    <input name="username" class="form-control" placeholder="Usuario" <?php if(isset($_GET['username'])) echo 'value="'.$_GET['username'].'"'; ?> required>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Contraseña<span style="color: red;">*</span>:</label>
                                            <input type="password" name="password" class="form-control" placeholder="Contraseña" required>   
                                        </div> 
                                        <div class="col-md-6">
                                            <label>Repite la contraseña<span style="color: red;">*</span>:</label>
                                            <input type="password" name="password2" class="form-control" placeholder="Contraseña" required>    
                                        </div>
                                        <a class="padding"></a>
                                    </div>
                                    <button type="submit" class="btn btn-danger">Registrarse</button>
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