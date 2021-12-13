<?php session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    die();
}

$orden = $_POST['orden'];


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
            <div class="row">
                <div class="col-md-1"></div>
                <!--primera columna vacía-->
                <div class="col-md-10">
                    <div class="shadow-lg p-4 mb-5 bg-body rounded">

                        <form action="visualitzarUsuarisBD.php" method="post" enctype="multipart/form-data"></form>
                        <form action="visualitzarUsuarisBD.php" method="post" enctype="multipart/form-data">
                            <div class="d-grid gap-2">
                                <div class="row">
                                <div class="col"></div>
                                <div class="col"></div>
                                    <div class="col"></div>
                                    <div class="col"></div>
                                    <div class="col"></div>
                                    <div class="col"></div>
                                    <div class="col"></div>
                                    <div class="col"></div>
                                    <div class="col"></div>
                                    <div class="col">
                                        <label>Ordenar por:</label>
                                        <select name="orden">
                                            <?php
                                            if ($orden == 'contActivos') {
                                                echo '<optgroup label="Categorías">
                                                    <option value="contActivos" selected>contratos activos</option>
                                                    <option value="noActivos">contratos inactivos</option>
                                                    <option value="todos">todos los usuarios por orden alfabético</option>
                                                </optgroup>';
                                            } else if ($orden == 'noActivos') {
                                                echo '<optgroup label="Categorías">
                                                    <option value="contActivos">contratos activos</option>
                                                    <option value="noActivos" selected>contratos inactivos</option>
                                                    <option value="todos">todos los usuarios por orden alfabético</option>
                                                </optgroup>';
                                            } else {
                                                echo '<optgroup label="Categorías">
                                                    <option value="contActivos">contratos activos</option>
                                                    <option value="noActivos">contratos inactivos</option>
                                                    <option value="todos" selected>todos los usuarios por orden alfabético</option>
                                                </optgroup>';
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="col" style="padding-top: 2%;">
                                        <input type="submit" value="Ordenar" class="btn btn-danger" style="width: 60px; height: 28px; font-size: 9pt; padding: 0px;">
                                    </div>
                                </div>
                            </div>
                        </form>



                        <div class="table table-responsive table-bordered" style="padding-top: 3%;">
                            <table class="table">
                                <thead>
                                    <tr style="background-color: black; color: white;">
                                        <th>Nombre de usuario</th>
                                        <th>Id contrato</th>
                                        <th>Estado</th>
                                        <th>Tarifa</th>
                                        <th>Fecha de alta</th>
                                        <th>Fecha de baja</th>
                                        
                                    </tr>
                                </thead>

                                    <?php
                                    if ($orden == 'contActivos') {
                                        $consultP = "SELECT * from contracte WHERE estat='1'";
                                        $resultP = mysqli_query($con, $consultP);

                                        if (mysqli_num_rows($resultP) > 0) {
                                            while ($fila1 = mysqli_fetch_assoc($resultP)) {
                                                $dataAlta = $fila1['dataAlta'];
                                                $dataBaixa = $fila1['dataBaixa'];
                                                $estat = $fila1['estat'];
                                                $idContracte = $fila1['IdContracte'];
                                                $nomTarifa = $fila1['nomTarifa'];
                                                $username = $fila1['username'];
                                                if($estat == 1) $estat = 'Activo';
                                                else $estat = 'Inactivo';
                                                echo '
                                            <tbody>
                                            <tr>
                                                <td>' . $username . '</td>
                                                <td>' . $idContracte . '</td>
                                                <td>' . $estat . '</td>
                                                <td>' . $nomTarifa . '</td>
                                                <td>' . $dataAlta . '</td>
                                                <td>' . $dataBaixa . '</td>
                                                </tr>
                                            </tbody>
                                            ';
                                            }
                                        }
                                    } else if ($orden == 'noActivos') {
                                        $consultP = "SELECT * from contracte WHERE estat='0'";
                                        $resultP = mysqli_query($con, $consultP);

                                        if (mysqli_num_rows($resultP) > 0) {
                                            while ($fila1 = mysqli_fetch_assoc($resultP)) {
                                                $dataAlta = $fila1['dataAlta'];
                                                $dataBaixa = $fila1['dataBaixa'];
                                                $estat = $fila1['estat'];
                                                $idContracte = $fila1['IdContracte'];
                                                $nomTarifa = $fila1['nomTarifa'];
                                                $username = $fila1['username'];
                                                if($estat == 1) $estat = 'Activo';
                                                else $estat = 'Inactivo';
                                                echo '
                                            <tr>
                                                <td>' . $username . '</td>
                                                <td>' . $idContracte . '</td>
                                                <td>' . $estat . '</td>
                                                <td>' . $nomTarifa . '</td>
                                                <td>' . $dataAlta . '</td>
                                                <td>' . $dataBaixa . '</td>
                                            </tr>
                                            ';
                                            }
                                        }
                                    } else {
                                        $consultP = "SELECT * from contracte ORDER BY username";
                                        $resultP = mysqli_query($con, $consultP);

                                        if (mysqli_num_rows($resultP) > 0) {
                                            while ($fila1 = mysqli_fetch_assoc($resultP)) {
                                                $dataAlta = $fila1['dataAlta'];
                                                $dataBaixa = $fila1['dataBaixa'];
                                                $estat = $fila1['estat'];
                                                $idContracte = $fila1['IdContracte'];
                                                $nomTarifa = $fila1['nomTarifa'];
                                                $username = $fila1['username'];
                                                if($estat == 1) $estat = 'Activo';
                                                else $estat = 'Inactivo';
                                                echo '
                                            <tr>
                                                <td>' . $username . '</td>
                                                <td>' . $idContracte . '</td>
                                                <td>' . $estat . '</td>
                                                <td>' . $nomTarifa . '</td>
                                                <td>' . $dataAlta . '</td>
                                                <td>' . $dataBaixa . '</td>
                                            </tr>
                                            ';
                                            }
                                        }
                                    }
                                    ?>
                            </table>
                        </div>

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
</body>

</html>