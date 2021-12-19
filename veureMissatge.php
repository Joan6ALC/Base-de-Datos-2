<?php session_start();
include "connection.php";
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    die();
}

$id = $_GET['id'];

$query = "SELECT * FROM missatge WHERE IdMissatge = '".$id."'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$assumpte = $row['assumpte'];
$data = $row['data'];
$descripcio = $row['descripcio'];
$estat = $row['estatMissatge'];
$idContingut = $row['IdContingut'];

$query2 = "SELECT titol FROM contingut WHERE IdContingut = '".$idContingut."'";
$result2 = mysqli_query($con, $query2);
$row2 = mysqli_fetch_assoc($result2);
$titol = $row2['titol'];

$upd = "UPDATE missatge SET estatMissatge = 1 WHERE IdMissatge = '".$id."'";
mysqli_query($con, $upd);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>PelisTube - Tu plataforma de streaming</title>
    <!--Título que aparecerá en la pestaña del navegador-->
    <link rel="stylesheet" href="css/bootstrap.min.css" /> <!-- Importamos hoja de estilos de bootrstrap-->
    <link rel="stylesheet" href="styles.css" /> <!-- Nuestra propia hoja de estilos-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"> <!-- Iconos bootstrap -->
    <link rel="shortcut icon" href="img/icon.png" /> <!-- Icono de la pestaña-->
    <script language="JavaScript" type="text/javascript" src="scripts.js"></script> <!-- Para importar mi hoja de scripts propia -->
</head>

<body>

    <header>
        <?php include "navbar.php"; ?>
    </header>

    <section>

        <div class="container">
            <div class="padding"><br></div>
            <div class="row justify-content-md-center">
                
                <!--primera columna vacía-->
                <div class="col-md-7">
                    <div class="shadow-lg p-4 mb-5 bg-body rounded">
                        <div class="d-grid gap-2">
                            <div class="row">
                                
                                
                                <div class="col-sm-7 ms-1"><h3>Asunto: <?php echo $assumpte?> </h3></div>
                                <div class="col mb-0"><h5>Fecha: <?php echo $data?> </h5></div>
                                
                                
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                            </br></br>
                            <h4> Descripción </h4>
                            </br>
                                <h6> <?php echo $descripcio.$titol?>  </h6>
                            </br></br>

                            </div>
                        </div>
                        <center>
                            <?php 
                                echo '<a href="llistarMissatges.php" class="btn btn-danger mx-2" value = "Volver">Volver</a>';
                                echo '<a href="veureContingut.php?id='.$idContingut.'" class="btn btn-primary mx-2" value = "Ver contenido">Ver contenido</a>';
                            ?>
                        </center>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        PelisTube &copy; 2021
    </footer>

    <script>
        selectElement = document.querySelector('.ordenar');



        selectElement.addEventListener('change', (event) => {
            var ordenSelect = document.getElementById("ordenSelect");
            var id = ordenSelect.options[ordenSelect.selectedIndex].value;
            window.location.replace('llistarMissatges.php?orden=' + id);
        });
    </script>

    <!-- Frameworks -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>