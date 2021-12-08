<?php 
    include "connection.php";
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: index.php");
        die();
    }
    $user = $_SESSION['username'];


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
                            <form action="editarContracte.php" method="post">
                                <div class="d-grid gap-2">
                                    <label>Estado:</label>
                                    <select name="entrada1">
                                        <optgroup label="Estado">
                                        <?php
                                            $consulta = "SELECT estat FROM contracte WHERE username = '".$user."'";
                                            $resultado = mysqli_query($con,$consulta);
                                            $registro = mysqli_fetch_array($resultado);
                                            if($registro['estat'] == 1){
                                                echo "<option value = '1' selected='selected'>Actiu</option>";
                                                echo "<option value = '0' >Inactiu</option>";
                                             }elseif($registro['estat'] == 0){
                                                echo "<option value = '0' selected='selected'>Inactiu</option>";
                                                echo "<option value = '1' >Actiu</option>";
                                            }
                                        ?>
                                        </optgroup>
                                    </select>
                                    <label>Tipo de tarifa:</label>
                                    <select name="entrada2">
                                        <optgroup label="Tipo de tarifa">
                                            <?php
                                                $consul = 'select distinct (nomTarifa) from Tarifa';
                                                $resul1 = mysqli_query($con,$consul);
                                                $trobat = 'select nomTarifa from contracte where username = "'.$user.'"';
                                                $resul2 = mysqli_query($con,$trobat);
                                                $fila2 =  mysqli_fetch_array($resul2);

                                                if (mysqli_num_rows($resul1) > 0) {
                                                    while($fila1 = mysqli_fetch_assoc($resul1)){
                                                        if($fila1['nomTarifa'] == $fila2['nomTarifa']){
                                                            echo "<option value = '".$fila1['nomTarifa']."' selected='selected'>".$fila1['nomTarifa']."</option>";
                                                        }else{
                                                            echo "<option value = '".$fila1['nomTarifa']."'>".$fila1['nomTarifa']."</option>";
                                                        }
                                                        
                                                    }
                                                }
                                            ?>
                                        </optgroup>
                                    </select>
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