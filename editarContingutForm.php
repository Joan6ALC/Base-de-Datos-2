<?php
include "connection.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    die();
}

//$contract = $_SESSION['IdContracte'];
$consulta = "SELECT * FROM contingut";
$cerca = mysqli_query($con, $consulta);
$def = mysqli_fetch_array($cerca);

if (isset($_GET['nomPelicula'])) {
    $index = $_GET['nomPelicula'];
} else {
    $index = $def['titol'];
}

$consultPeli = 'SELECT * FROM contingut WHERE titol = "' . $index . '"';
$resultPeli = mysqli_query($con, $consultPeli);
$cerk = mysqli_fetch_array($resultPeli);
$peli = $cerk['titol'];

$visible = $cerk['visible'];


$consultCat = "SELECT nomCat FROM categoria";
$categoria = mysqli_query($con, $consultCat);
$novaCat = $cerk['nomCat'];

$enlace = $cerk['link'];
$imatge = $cerk['camiFoto'];

$resultTip = "SELECT IdTipus FROM r_tipus_contingut WHERE IdContingut = '" . $cerk['IdContingut'] . "'";
$tipusAct = mysqli_query($con, $resultTip);
$tAct = mysqli_fetch_array($tipusAct);

$resultTipus = "SELECT * FROM tipus";
$tipus = mysqli_query($con, $resultTipus);

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
    <link rel="stylesheet" href="dragBox.css" /> <!-- Nuestra propia hoja de estilos-->
    <link rel="shortcut icon" href="img/icon.png" /> <!-- Icono de la pestaña-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"> <!-- Iconos bootstrap -->
</head>

<body>
    <header>
        <?php
        include "navbar.php";
        if (isset($_GET['error'])) {
            switch ($_GET['error']) {
                case 1:
                    echo    '<div class="padding"></div><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-file-earmark-excel" style="font-size: 0.9rem;"></i>
                                &nbspLa película introducida ya existe
                            </div>';
                    break;
                case 2:
                    echo    '<div class="padding"></div><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-file-earmark-excel" style="font-size: 0.9rem;"></i>
                                &nbspYa existe una imagen con el mismo nombre
                            </div>';
                    break;
                default:
            }
        } ?>
    </header>
    <section>


        <div class="container">
            <div class="padding"><br></div>
            <div class="row">
                <div class="col-md-3"></div>
                <!--primera columna vacía-->
                <div class="col-md-6">
                    <div class="shadow-lg p-4 mb-5 bg-body rounded">
                        <!--<form action="afegirContingut.php" method="post" enctype="multipart/form-data"></form>-->
                        <form action="editarContingut.php" method="post" enctype="multipart/form-data">
                            <div class="d-grid gap-2">

                                <div class="row">
                                    <div class="col">
                                        <label>Selecciona el contenido a editar<span style="color: red;">*</span>:</label>
                                        <select class="titulos my-2" name="titolSelect" id="titolSelect">

                                            <?php
                                            $titulosTotal = "SELECT * FROM contingut";

                                            $res = mysqli_query($con, $titulosTotal);

                                            if (mysqli_num_rows($res) > 0) {
                                                while ($fila1 = mysqli_fetch_assoc($res)) {

                                                    if ($index == $fila1['titol']) {
                                                        echo '<option value="' . $fila1['titol'] . '" selected ="selected" >' . $fila1['titol'] . '</option>';
                                                    } else {
                                                        echo '<option value="' . $fila1['titol'] . '">' . $fila1['titol'] . '</option>';
                                                    }
                                                    //echo "<option value = '" . $fila1['titol'] . "' selected='selected'>" . $fila1['titol'] . "</option>";
                                                }
                                            }
                                            ?>

                                        </select>
                                        <script>
                                            selectElement = document.querySelector('.titulos');
                                            selectElement.addEventListener('change', (event) => {
                                                var titolSelect = document.getElementById("titolSelect");
                                                var id = titolSelect.options[titolSelect.selectedIndex].value;
                                                window.location.replace('editarContingutForm.php?nomPelicula=' + id);
                                            });
                                        </script>



                                        <label class=" mt-3">Título del contenido<span style="color: red;">*</span>:</label>
                                        <input class=" my-2" type="text" id="titulo" name="titulo" value=<?php echo "'" . $peli . "'" ?> required><br>



                                        <label class=" mt-3">Enlace del contenido<span style="color: red;">*</span>:</label>
                                        <input class=" my-2" type="text" id="enlace" name="enlace" value=<?php echo "'" . $enlace . "'" ?> required><br>
                                    </div>
                                    <div class="col"></div>
                                    <div class="col">
                                        <label class=" my-2">Categoría<span style="color: red;">*</span>:</label>
                                        <select name="nomCat">
                                            <optgroup label="Categorías">
                                                <?php
                                                if (mysqli_num_rows($categoria) > 0) {
                                                    while ($fila1 = mysqli_fetch_assoc($categoria)) {
                                                        if ($fila1['nomCat'] == $novaCat) {
                                                            echo "<option value = '" . $fila1['nomCat'] . "' selected='selected'>" . $novaCat . "</option>";
                                                        } else {
                                                            echo "<option value = '" . $fila1['nomCat'] . "'>" . $fila1['nomCat'] . "</option>";
                                                        }
                                                    }
                                                }
                                                ?>
                                            </optgroup>
                                        </select>


                                        <label class=" mt-3">Tipo de contenido<span style="color: red;">*</span>:</label>

                                        <?php
                                        if (mysqli_num_rows($tipus) > 0) {
                                            while ($fila1 = mysqli_fetch_assoc($tipus)) {
                                                if ($fila1['IdTipus'] == $tAct['IdTipus']) {
                                                    $tAct = mysqli_fetch_assoc($tipusAct);
                                                    echo "<br /><input  class = 'my-2 ms-4' type='checkbox' name='tipoCont[]' value = '" . $fila1['edat'] . "' checked ><label> " . $fila1['edat'] . "</label></input>";
                                                } else {
                                                    echo "<br /><input  class = 'my-2 ms-4' type='checkbox' name='tipoCont[]' value = '" . $fila1['edat'] . "' ><label> " . $fila1['edat'] . "</label></input>";
                                                }
                                            }
                                        }

                                        ?>

                                        <label class=" mt-3">Visible:</label>
                                        <?php

                                        if ($visible == 1) {
                                            echo "<input  class = 'my-2 ms-2' type='checkbox' name='visible' value = '1' checked></input>";
                                        } else {
                                            echo "<input  class = 'my-2 ms-2' type='checkbox' name='visible' value = '1'></input>";
                                        }
                                        ?>
                                    </div>

                                    <div class="col">

                                    </div>

                                </div>

                                <div class="dragArea">
                                    <header style="color: darkgray;">Arrastra o selecciona el archivo para subirlo </header>
                                    <input type="file" id="file" name="file" accept="image/jpeg, image/png" class="form-control">
                                </div>

                            </div>

                            <div class="alerta"></div>

                            <div style="padding: 3%; text-align: center;">
                                <input type="submit" value="Aceptar cambios" name="update" class="btn btn-danger">
                                <input type="submit" value="Eliminar" name="delete" class="btn btn-danger">
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div style="color: grey; font-size: 9px">PelisTube &copy; 2021</div>
    </footer>

    <style>
        body {
            background-image: url("img/background2.jpg");
            background-position: absolute;
        }
    </style>
    <!-- Frameworks -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="dragBox.js"></script>
</body>

</html>