<?php 
    include "connection.php";
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: index.html");
        die();
    }
    $user = $_SESSION['username'];
    $consulta = "SELECT dataAlta,username,password,llinatge1,llinatge2,nom FROM persona WHERE username = '$user'";
    $resultado = mysqli_query($con,$consulta);
    $registro = mysqli_fetch_array($resultado);

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
        <section> 
            <div class="container">
                <div class="row ">
                    <div class="col-md-3"></div> <!--primera columna vacía-->
                    <div class="col-md-6">
                        <div class="shadow-lg p-4 mb-5 bg-body rounded">
                            <form action="editarPerfil.php" method="post">
                                <div class="d-grid gap-2">
                                    <label>Nombre:</label>
                                    <input name="name" class="form-control" placeholder="<?php echo $registro['nom'] ?>" <?php if(isset($_GET['name'])) echo 'value="'.$_GET['name'].'"'; ?>required>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Primer apellido:</label>
                                            <input name="surname1" class="form-control" placeholder="<?php echo $registro['llinatge1']; ?>" <?php if(isset($_GET['surname1'])) echo 'value="'.$_GET['surname1'].'"'; ?> required>
                                        </div> 
                                        <div class="col-md-6">
                                            <label>Segundo apellido:</label>
                                            <input name="surname2" class="form-control" placeholder="<?php echo $registro['llinatge1']; ?>" <?php if(isset($_GET['surname2'])) echo 'value="'.$_GET['surname2'].'"'; ?>>       
                                        </div> 
                                    </div>

                                    
                                    <label>Fecha de nacimiento:</label>
                                    <input type="date" name="dateofbirth" class="form-control" placeholder="<?php echo $registro['dataAlta']; ?>" min="1920-1-01" max="2023-12-31" <?php if(isset($_GET['dob'])) echo 'value="'.$_GET['dob'].'"'; ?> required>
                                    <label>Usuario:</label>
                                    <input name="username" class="form-control" placeholder="<?php echo $user ?>" <?php if(isset($_GET['username'])) echo 'value="'.$_GET['username'].'"'; ?> required>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Contraseña:</label>
                                            <input type="password" name="password" class="form-control" placeholder="Contraseña" required>   
                                        </div> 
                                        <div class="col-md-6">
                                            <label>Repite la contraseña:</label>
                                            <input type="password" name="password2" class="form-control" placeholder="Contraseña" required>    
                                        </div>
                                        <a class="padding"></a>
                                        <?php if (isset($_GET['error'])){
                                            switch ($_GET['error']) {
                                                case 1:
                                                    echo '<div class="error-message">Las contraseñas no coinciden</div>';
                                                    break;
                                                case 2:
                                                    echo '<div class="error-message">El nombre de usuario elegido ya existe</div>';
                                                    break;
                                                default:
                                            }
                                        } ?>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-danger">Aceptar cambios</button>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Frameworks -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>