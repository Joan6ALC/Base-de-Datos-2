<?php
include "connection.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    die();
}

$consulta = "SELECT * FROM categoria";
$cerca = mysqli_query($con, $consulta);
$def = mysqli_fetch_array($cerca);

if (isset($_GET['nomCategoria'])) {
    $index = $_GET['nomCategoria'];
} else {
    $index = $def['nomCat'];
}

$consultCat = 'SELECT * FROM categoria WHERE nomCat = "' . $index . '"';
$resultCat= mysqli_query($con, $consultCat);
$cerk = mysqli_fetch_array($resultCat);
$cat = $cerk['nomCat'];

$visible = $cerk['visible'];

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

        if (isset($_GET['msg'])) {
            switch ($_GET['msg']) {
                case 1: // EDICIÓ
                    echo    '<div class="padding"></div><div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi-check2-square" style="font-size: 0.9rem;"></i>
                                &nbspCategoría editada correctamente
                                <button type="button" style="background-color: transparent; border: 0px; class="close" data-dismiss="alert" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
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
                        <form action="editarCategoria.php" method="post" enctype="multipart/form-data">
                            <div class="d-grid gap-2">

                                <div class="row">
                                    <div class="col-md-auto">
                                        <label>Selecciona la categoría a editar<span style="color: red;">*</span>:</label>
                                        <select class="categorias my-2" name="catSelect" id="catSelect">

                                            <?php
                                            $catTotal = "SELECT * FROM categoria";

                                            $res = mysqli_query($con, $catTotal);

                                            if (mysqli_num_rows($res) > 0) {
                                                while ($fila1 = mysqli_fetch_assoc($res)) {

                                                    if ($index == $fila1['nomCat']) {
                                                        echo '<option value="' . $fila1['nomCat'] . '" selected ="selected" >' . $fila1['nomCat'] . '</option>';
                                                    } else {
                                                        echo '<option value="' . $fila1['nomCat'] . '">' . $fila1['nomCat'] . '</option>';
                                                    }
                                                    //echo "<option value = '" . $fila1['titol'] . "' selected='selected'>" . $fila1['titol'] . "</option>";
                                                }
                                            }
                                            ?>

                                        </select>
                                        <script>
                                            selectElement = document.querySelector('.categorias');
                                            selectElement.addEventListener('change', (event) => {
                                                var catSelect = document.getElementById("catSelect");
                                                var id = catSelect.options[catSelect.selectedIndex].value;
                                                window.location.replace('editarCategoriaForm.php?nomCategoria=' + id);
                                            });
                                        </script>

                                        
                                    </div>
                                    <div class="col"></div>
                                    <div class="col-md-auto">
                                        


                                        <label class="mt-2">Visible:</label>
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


                            </div>

                            <div class="alerta"></div>

                            <div style="padding: 3%; text-align: center;">
                                <input type="submit" value="Aceptar cambios" name="update" class="btn btn-success">
                                <!--<input type="submit" value="Eliminar" name="delete" class="btn btn-danger">-->

                                <?php //echo '<a href="eliminarCategoria.php?id='.$cerk['nomCat'].'&redir=editarContingutForm.php" class="btn btn-danger">Eliminar</a>';
                                ?>
                               
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
    <script src="dragBox.js"></script>
</body>

</html>