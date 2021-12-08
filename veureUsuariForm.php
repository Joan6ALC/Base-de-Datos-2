<?php 
    include "connection.php";
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: index.php");
        die();
    }
    $user = $_SESSION['username'];
    $consulta = "SELECT username,password,llinatge1,llinatge2,dataNaixament,nom FROM persona WHERE username = '".$user."'";
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
            <div class = "padding"><br></div>
                <div class="row">
                    <div class="col-md-3"></div> <!--primera columna vacía-->
                    <div class="col-md-6">
                        <div class="shadow-lg p-4 mb-5 bg-body rounded">
                            <form action="editarUsuariForm.php" method="post">
                                <div class="d-grid gap-2">
                                <label>Usuario:</label>
                                    <input name="username" class="form-control" value="<?php echo $user ?>" readonly>

                                    <label>Nombre:</label>
                                    <input name="name" class="form-control" value="<?php echo $registro['nom']; ?>" readonly>
        
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Primer apellido:</label>
                                            <input name="surname1" class="form-control" value="<?php echo $registro['llinatge1']; ?>" readonly>
                                        </div> 
                                        <div class="col-md-6">
                                            <label>Segundo apellido:</label>
                                            <input name="surname2" class="form-control" value="<?php echo $registro['llinatge2']; ?>" readonly>       
                                        </div> 
                                    </div>
                                    
                                    <label>Fecha de nacimiento:</label>
                                    <input type="date" name="dateofbirth" class="form-control" min="1920-1-01" max="2023-12-31" value ="<?php echo $registro['dataNaixament']; ?>" readonly>
                                    <div class="col-md-6">
                                    <button type="submit" class="btn btn-danger">Editar</button>
                                    </div>
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