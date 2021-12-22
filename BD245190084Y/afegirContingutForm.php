<?php
// Conexión con la base de datos
include "connection.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    die();
}


// Seleccionamos los valores necesariospara rellenar el formulario con valores predeterminads
$consultP = 'select distinct (nomCat) from categoria';
$resultP = mysqli_query($con, $consultP);

$consultQ = 'select * from tipus';
$resultQ = mysqli_query($con, $consultQ);

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
    <link rel="stylesheet" href="dragBox.css" /> <!-- Hoja de estilos própia, para el dragBox -->
    <link rel="shortcut icon" href="img/icon.png" /> <!-- Icono de la pestaña-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"> <!-- Iconos bootstrap -->
</head>

<body>
    <header>
        <?php
        include "navbar.php";
        // En caso que haya un error, comprueba cual es y muestra el mensaje de error
        if (isset($_GET['error'])) {
            switch ($_GET['error']) {
                // Si la película introducida ya existe error=1
                case 1:
                    echo    '<div class="padding"></div><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-file-earmark-excel" style="font-size: 0.9rem;"></i>
                                &nbspLa película introducida ya existe
                            </div>';
                    break;
                // Si ya existe una imagen con el mismo nombre error=2
                case 2:
                    echo    '<div class="padding"></div><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-file-earmark-excel" style="font-size: 0.9rem;"></i>
                                &nbspYa existe una imagen con el mismo nombre
                            </div>';
                    break;
                // Si no se ha seleccionado nngún valor para tipo de contenido, error=3
                case 3:
                    echo    '<div class="padding"></div><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-file-earmark-excel" style="font-size: 0.9rem;"></i>
                                    &nbsp ¡Ningún valor seleccionado para tipo de contenido!
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
                        <form action="afegirContingut.php" method="post" enctype="multipart/form-data"></form>
                        <form action="afegirContingut.php" method="post" enctype="multipart/form-data">
                            <div class="d-grid gap-2">

                                <div class="row">
                                    <div class="col">
                                        <!-- Capo obligatorio de título de contenido -->
                                        <label>Título de la película<span style="color: red;">*</span>:</label>
                                        <input type="text" id="titulo" name="titulo" required><br>
                                        <!-- Capo obligatorio de enlace de contenido -->
                                        <label>Enlace de la película<span style="color: red;">*</span>:</label>
                                        <input type="text" id="enlace" name="enlace" required><br>
                                    </div>
                                    <div class="col">
                                        <!-- Listado de selección de una categoría -->
                                        <label>Categoría<span style="color: red;">*</span>:</label>
                                        <select name="nomCat">
                                            <optgroup label="Categorías">
                                                <?php
                                                if (mysqli_num_rows($resultP) > 0) {
                                                    while ($fila1 = mysqli_fetch_assoc($resultP)) {
                                                        echo "<option value = '" . $fila1['nomCat'] . "' selected='selected'>" . $fila1['nomCat'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </optgroup>
                                        </select>
                                    </div>

                                    <div class="col">
                                        <!-- Capo obligatorio de tipo de contenido -->
                                        <label>Tipo de contenido<span style="color: red;">*</span>:</label>
                                        <?php
                                        if (mysqli_num_rows($resultQ) > 0) {
                                            while ($fila1 = mysqli_fetch_assoc($resultQ)) {
                                                echo "<br /><input type='checkbox' name='tipoCont[]' value='" . $fila1['edat'] . "'><label> " . $fila1['edat'] . "</label></input>";
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="dragArea">
                                    <!-- dragBox para añadir una imagen de portada -->
                                    <header style="color: darkgray;">Arrastra o selecciona el archivo para subirlo <span style="color: red;">*</span></header>
                                    <input type="file" id="file" name="file" accept="image/jpeg, image/png" class="form-control" required>
                                </div>

                            </div>

                            <div class="alerta"></div>

                            <div style="padding: 3%; text-align: center;">
                            <!-- Botón para enviar el formulario y ejecutar "afegirContingut.php" -->
                                <input type="submit" value="Insertar película" class="btn btn-danger">
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