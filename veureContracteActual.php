<?php 
    include "connection.php";
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: index.php");
        die();
    }
    $user = $_SESSION['username'];
    $consulta = "SELECT * FROM contracte WHERE username = '".$user."'";
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
            <div class = "row">
            <div class="col-md-3"></div> <!--primera columna vacía-->
                    <div class="col-md-6">
                        <div class="shadow-lg p-4 mb-5 bg-body rounded">
                            <form action="editarContracteForm.php" method="post">
                                <div class="d-grid gap-2">
                                    <label>Nombre de usuario:</label>
                                    <input name="nameus" class="form-control" value=" <?php echo $registro['username']; ?>" readonly>
                                    
                                    
                                    <label>Tipo de tarifa:</label>
                                    <input name="nametar" class="form-control" value=" <?php echo $registro['nomTarifa']; ?>" readonly>
                                    

                                    <label>Estado:</label>
                                    <?php 
                                        if($registro['estat'] == 1){
                                            echo '<input name="est" class="form-control" value="Actiu" readonly>';
                                        }else{
                                            echo '<input name="est" class="form-control" value="Inactiu" readonly>';
                                        }
                                    ?>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Fecha de alta:</label>
                                            <input type="date" name="dataalta" class="form-control" value ="<?php echo $registro['dataAlta']; ?>" readonly>
                                        </div> 
                                        <div class="col-md-6">
                                            <label>Fecha de baja:</label>
                                            <input type="date" name="databaixa" class="form-control" value ="<?php echo $registro['dataBaixa']; ?>"readonly>
                                        </div> 
                                    </div>

                                    <label>Id de su contrato:</label>
                                    <input name="id" class="form-control" value=" <?php echo $registro['IdContracte']; ?>" readonly>
                                    

                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-danger">Editar Contrato</button>
                                        </div> 
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