<?php
include "connection.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    die();
}

//Seleccionam els continguts
$consulta = "SELECT * FROM contingut";
$cerca = mysqli_query($con, $consulta);
$def = mysqli_fetch_array($cerca);

//Comprovam els valors passats per paràmetre i els guardam
if (isset($_GET['nomPelicula'])) {
    $index = $_GET['nomPelicula'];
} else {
    $index = $def['titol'];
}

//Cercam el contingut que coincideix amb el passat per paràmetre
$consultPeli = 'SELECT * FROM contingut WHERE titol = "' . $index . '"';
$resultPeli = mysqli_query($con, $consultPeli);
$cerk = mysqli_fetch_array($resultPeli);
$peli = $cerk['titol'];

$visible = $cerk['visible'];

//Seleccionam totes les categories
$consultCat = "SELECT nomCat FROM categoria";
$categoria = mysqli_query($con, $consultCat);

//Guardam el valor de la nova categoria
$novaCat = $cerk['nomCat'];

$enlace = $cerk['link'];
$imatge = $cerk['camiFoto'];

//Cercam el tipus de public al que va dirigit el contingut
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
    <link rel="stylesheet" href="css/styles.css" /> <!-- Nuestra propia hoja de estilos-->
    <link rel="stylesheet" href="dragBox.css" /> <!-- Nuestra propia hoja de estilos-->
    <link rel="shortcut icon" href="img/icon.png" /> <!-- Icono de la pestaña-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"> <!-- Iconos bootstrap -->
</head>

<body>
    <header>
        <?php
        include "navbar.php";
        include "missatge.php";

        //Missatges d'error específics
        if (isset($_GET['error'])) {
            switch ($_GET['error']) {
                case 1: // TITOL DE LA PELICULA JA EXISTEIX
                    echo    '<div class="padding"></div><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi-check2-square" style="font-size: 0.9rem;"></i>
                                &nbspLa película introducida ya existe
                                <button type="button" style="background-color: transparent; border: 0px; class="close" data-dismiss="alert" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                    break;
                case 2: // FOTO JA INTRODUIDA
                    echo    '<div class="padding"></div><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi-check2-square" style="font-size: 0.9rem;"></i>
                                &nbspYa existe una imagen con el mismo nombre
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
                <div class="col-md-6">
                    <div class="shadow-lg p-4 mb-5 bg-body rounded">
                        <!--Formulari per introduir les dades del contingut-->
                        <form action="editarContingut.php" method="post" enctype="multipart/form-data">
                            <div class="d-grid gap-2">
                                <div class="row">
                                    <div class="col">
                                        <!--Seleccionam el titol del contingut a editar-->
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
                                                    }
                                                }
                                            ?>

                                        </select>
                                        <script> //Script qwe ens passa per paràmetre l'id del contingut a editar
                                            selectElement = document.querySelector('.titulos');
                                            selectElement.addEventListener('change', (event) => {
                                                var titolSelect = document.getElementById("titolSelect");
                                                var id = titolSelect.options[titolSelect.selectedIndex].value;
                                                window.location.replace('editarContingutForm.php?nomPelicula=' + id);
                                            });
                                        </script>
                                        <!--Inserim el nou títol-->
                                        <label class=" mt-3">Título del contenido<span style="color: red;">*</span>:</label>
                                        <input class=" my-2" type="text" id="titulo" name="titulo" value=<?php echo "'" . $peli . "'" ?> required><br>
                                        <!--Inserim el nou enllaç-->
                                        <label class=" mt-3">Enlace del contenido<span style="color: red;">*</span>:</label>
                                        <input class=" my-2" type="text" id="enlace" name="enlace" value=<?php echo "'" . $enlace . "'" ?> required><br>
                                    </div>
                                    <div class="col"></div>
                                    <div class="col">
                                        <!--Selecció de la nova categoria-->
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
                                        <!--Selecció del nou tipus-->
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
                                        <!--Selecció de la visibilitat-->
                                        <label class=" mt-3">Visible:</label>
                                        <?php
                                            if ($visible == 1) {
                                                echo "<input  class = 'my-2 ms-2' type='checkbox' name='visible' value = '1' checked></input>";
                                            } else {
                                                echo "<input  class = 'my-2 ms-2' type='checkbox' name='visible' value = '1'></input>";
                                            }
                                        ?>
                                    </div>
                                    <div class="col"></div>
                                </div>
                                <!--Selecció de la nova imatge-->
                                <div class="dragArea">
                                    <header style="color: darkgray;">Arrastra o selecciona el archivo para subirlo </header>
                                    <input type="file" id="file" name="file" accept="image/jpeg, image/png" class="form-control">
                                </div>

                            </div>
                            <div class="alerta"></div>
                            <!--Inserim els botons per gaurdar els canvis o eliminar el contingut-->
                            <div style="padding: 3%; text-align: center;">
                                <input type="submit" value="Aceptar cambios" name="update" class="btn btn-success">
                                <?php echo '<a href="eliminarContingut.php?id='.$cerk['IdContingut'].'&redir=editarContingutForm.php" class="btn btn-danger">Eliminar</a>';
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