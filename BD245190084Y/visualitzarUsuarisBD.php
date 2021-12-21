<?php session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    die();
}

if (isset($_GET['orden'])) {
    $orden = $_GET['orden'];
} else {
    $orden = 'todos';
}


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
                                    <select class="ordenar" name="ordenSelect" id="ordenSelect">
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
                            </div>
                        </div>



                        <div class="table table-responsive table-bordered" style="padding-top: 3%;">
                            <table class="table">

                                <?php
                                if ($orden == 'contActivos') {
                                    $consultP = "SELECT persona.username, persona.dataAlta, nom, llinatge1,llinatge2, edat, estat, IdContracte, nomTarifa FROM tipus JOIN (persona JOIN contracte ON persona.username=contracte.username AND contracte.estat='1') ON tipus.IdTipus=persona.IdTipus";
                                    $resultP = mysqli_query($con, $consultP);

                                    echo '
                                    <thead>
                                        <tr style="background-color: black; color: white;">
                                            <th>Id contrato</th>
                                            <th>Nombre de usuario</th>
                                            <th>Nombre completo</th>
                                            <th>Estado</th>
                                            <th>Tarifa</th>
                                            <th>Fecha de alta de usuario</th>
                                            <th>Edad</th>
                                        </tr>
                                    </thead>                                    
                                    ';

                                    if (mysqli_num_rows($resultP) > 0) {
                                        while ($fila1 = mysqli_fetch_assoc($resultP)) {
                                            $idContracte = $fila1['IdContracte'];
                                            $username = $fila1['username'];
                                            $nombre = $fila1['nom'];
                                            $apellido1 = $fila1['llinatge1'];
                                            $apellido2 = $fila1['llinatge2'];
                                            $estat = $fila1['estat'];
                                            $nomTarifa = $fila1['nomTarifa'];
                                            $dataAlta = $fila1['dataAlta'];
                                            $edad = $fila1['edat'];

                                            if ($estat == 1) $estat = 'Activo';
                                            else $estat = 'Inactivo';

                                            echo '
                                            <tbody>
                                            <tr>
                                                <td>' . $idContracte . '</td>
                                                <td>' . $username . '</td>
                                                <td>' . $apellido1 . ' ' . $apellido2 . ', ' . $nombre . '</td>
                                                <td>' . $estat . '</td>
                                                <td>' . $nomTarifa . '</td>
                                                <td>' . $dataAlta . '</td>
                                                <td>' . $edad . '</td>
                                                </tr>
                                            </tbody>
                                            ';
                                        }
                                    }
                                } else if ($orden == 'noActivos') {
                                    $consultP = "SELECT persona.username, persona.dataAlta, nom, llinatge1,llinatge2, edat, estat, IdContracte, nomTarifa FROM tipus JOIN (persona JOIN contracte ON persona.username=contracte.username AND contracte.estat='0') ON tipus.IdTipus=persona.IdTipus";
                                    $resultP = mysqli_query($con, $consultP);

                                    echo '
                                        <thead>
                                            <tr style="background-color: black; color: white;">
                                                <th>Id contrato</th>
                                                <th>Nombre de usuario</th>
                                                <th>Nombre completo</th>
                                                <th>Estado</th>
                                                <th>Tarifa</th>
                                                <th>Fecha de alta de usuario</th>
                                                <th>Edad</th>
                                            </tr>
                                        </thead>                                    
                                        ';

                                    if (mysqli_num_rows($resultP) > 0) {
                                        while ($fila1 = mysqli_fetch_assoc($resultP)) {
                                            $idContracte = $fila1['IdContracte'];
                                            $username = $fila1['username'];
                                            $nombre = $fila1['nom'];
                                            $apellido1 = $fila1['llinatge1'];
                                            $apellido2 = $fila1['llinatge2'];
                                            $estat = $fila1['estat'];
                                            $nomTarifa = $fila1['nomTarifa'];
                                            $dataAlta = $fila1['dataAlta'];
                                            $edad = $fila1['edat'];

                                            if ($estat == 1) $estat = 'Activo';
                                            else $estat = 'Inactivo';

                                            echo '
                                                <tbody>
                                                <tr>
                                                    <td>' . $idContracte . '</td>
                                                    <td>' . $username . '</td>
                                                    <td>' . $apellido1 . ' ' . $apellido2 . ', ' . $nombre . '</td>
                                                    <td>' . $estat . '</td>
                                                    <td>' . $nomTarifa . '</td>
                                                    <td>' . $dataAlta . '</td>
                                                    <td>' . $edad . '</td>
                                                    </tr>
                                                </tbody>
                                                ';
                                        }
                                    }
                                } else {
                                    $consultP = "SELECT username, nom, llinatge1, llinatge2, dataAlta, edat FROM persona JOIN tipus WHERE persona.IdTipus=tipus.IdTipus ORDER BY username";
                                    $resultP = mysqli_query($con, $consultP);

                                    echo '
                                        <thead>
                                            <tr style="background-color: black; color: white;">
                                                <th>Nombre de usuario</th>
                                                <th>Nombre completo</th>
                                                <th>Fecha de alta de usuario</th>
                                                <th>Edad</th>
                                            </tr>
                                        </thead>                                    
                                        ';

                                    if (mysqli_num_rows($resultP) > 0) {
                                        while ($fila1 = mysqli_fetch_assoc($resultP)) {
                                            $username = $fila1['username'];
                                            $nombre = $fila1['nom'];
                                            $apellido1 = $fila1['llinatge1'];
                                            $apellido2 = $fila1['llinatge2'];
                                            $dataAlta = $fila1['dataAlta'];
                                            $edad = $fila1['edat'];

                                            echo '
                                                <tbody>
                                                <tr>
                                                    <td>' . $username . '</td>
                                                    <td>' . $apellido1 . ' ' . $apellido2 . ', ' . $nombre . '</td>
                                                    <td>' . $dataAlta . '</td>
                                                    <td>' . $edad . '</td>
                                                    </tr>
                                                </tbody>
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

    <script>
        selectElement = document.querySelector('.ordenar');



        selectElement.addEventListener('change', (event) => {
            var ordenSelect = document.getElementById("ordenSelect");
            var id = ordenSelect.options[ordenSelect.selectedIndex].value;
            window.location.replace('visualitzarUsuarisBD.php?orden=' + id);
        });
    </script>

    <!-- Frameworks -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>