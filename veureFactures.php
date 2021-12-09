<?php 
    include "connection.php";
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: index.php");
        die();
    }
      
    $contract = $_SESSION['IdContracte'];
    $consulta = "SELECT * FROM factura WHERE IdContracte = '".$contract."'";
    $cerca = mysqli_query($con,$consulta);
    $def = mysqli_fetch_array($cerca);

    if($def['import'] == null){
        header("Location: nohihaFactures.php?redir=login.php");
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
        <section> 
            <div class="container">
            <div class = "padding"><br></div>
            <div class = "row">
            <div class="col-md-3"></div> <!--primera columna vacía-->
                    <div class="col-md-6">
                        <div class="shadow-lg p-4 mb-5 bg-body rounded">
                            
                                <div class="d-grid gap-2">
                                    <label>Id del Contrato:</label>
                                    <input name="contrac" class="form-control" value=<?php echo "'".$contract."'" ?> readonly>
                                    <form action="veureFactures.php" method="post">
                                        <label>Factura:</label>
                                            <select name="facturas">
                                                <optgroup>
                                                <?php
                                                    $facturastotal = "SELECT * FROM factura WHERE IdContracte = '".$contract."'";
                                                    $res = mysqli_query($con,$facturastotal);
                                                    if (mysqli_num_rows($res) > 0) {
                                                        while($fila = mysqli_fetch_assoc($res)){
                                                            $trob = $fila["IdFactura"];

                                                            echo "<option value='".$trob."'>".$trob."</option>";
                                                            $datapagfila = $fila["dataPagament"];
                                                            $dataInfila = $fila["dataInici"];
                                                            $dataFifila = $fila["dataFi"];
                                                            $importfila = $fila["import"]; 
                                                        }
                                                    }
                                                ?>
                                                </optgroup>
                                            </select>
                                    </form>
                                    <label>Data pagament:</label>
                                    <input type="date" name="datapag" class="form-control" value =<?php "'".$datapagfila."'" ?> readonly>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Data inici:</label>
                                            <input type="date" name="datain" class="form-control" value =<?php echo "'".$dataInfila."'" ?> readonly>
                                        </div> 
                                        <div class="col-md-6">
                                            <label>Data fi:</label>
                                            <input type="date" name="datafi" class="form-control" value =<?php echo "'".$dataFifila."'" ?> readonly>
                                        </div> 
                                    </div>
                                    <label>Import:</label>
                                    <input name="num" class="form-control" value=<?php echo "'".$importfila."'" ?> readonly>
                                    <div class="row">
                                        <div class="col-md-9">
                                        <form action="veureFacturesPagades.php" method="post" id="$trob">
                                            <button type="submit" class="btn btn-danger">Ver facturas pagadas</button>
                                        </form>
                                        </div>
                                            <?php
                                                if($datapagfila == null){
                                                    echo '<div class="col">';
                                                    echo '<a href="pagar.php?value='.$trob.'" class="btn btn-danger">Pagar</a>';
                                                    echo '</div>';
                                                }
                                            ?>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                        <form action="veureFacturesNoPagades.php" method="post" id="$trob">
                                            <button type="submit" class="btn btn-danger">Ver pendientes de pago</button>
                                        </form>
                                        </div>
                                    </div>
                                </div>  
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