<?php session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    die();
}

//Guardam els valors que ens passen per paràmetre
if (isset($_GET['orden'])) {
    $orden = $_GET['orden'];
} else {
    $orden = 'recientes';
}
include "connection.php";
//Missatges llegits
$consLlegits = "SELECT assumpte, data, IdMissatge FROM missatge WHERE missatge.username = '".$_SESSION['username']."' AND estatMissatge = 1 ORDER BY data DESC";
$resLlegits = mysqli_query($con, $consLlegits);
$fil = mysqli_fetch_array($resLlegits);

$consNoLlegits = "SELECT assumpte, data, IdMissatge FROM missatge WHERE missatge.username = '".$_SESSION['username']."' AND estatMissatge = 0 ORDER BY data DESC";
$resNoLlegits = mysqli_query($con, $consNoLlegits);
$filNo = mysqli_fetch_array($resNoLlegits);

$consTots = "SELECT assumpte, data, IdMissatge FROM missatge WHERE missatge.username = '".$_SESSION['username']."'";
$resTots = mysqli_query($con, $consTots);
$filTots = mysqli_fetch_array($resTots);

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
                <div class="col-md-10">
                    <div class="shadow-lg p-4 mb-5 bg-body rounded">
                        <div class="d-grid gap-2">
                            <div class="row">
                                <div class="col-sm-7 ms-1"><h3>Buzón de mensajes</h3></div>
                                <div class="col-sm-4 align-self-lg-end">
                                    <!--Selecció de l'ordre en que es volen veure els missatges-->
                                    <label>Ordenar por:</label>
                                    <select class="ordenar" name="ordenSelect" id="ordenSelect">
                                        <?php
                                            if ($orden == 'abiertos') { //Només missatges oberts
                                                echo '<optgroup label="Selección">
                                                        <option value="recientes">Más recientes primero</option>
                                                        <option value="noRecientes">Menos recientes primero</option>
                                                        <option value="abiertos" selected>Leídos</option>
                                                        <option value="noAbiertos">No leídos</option>                                                    
                                                    </optgroup>';
                                            } else if ($orden == 'noRecientes') {//Missatges més antics primer
                                                echo '<optgroup label="Selección">
                                                        <option value="recientes">Más recientes primero</option>
                                                        <option value="noRecientes" selected>Menos recientes primero</option>
                                                        <option value="abiertos">Leídos</option>
                                                        <option value="noAbiertos">No leídos</option>                                                    
                                                    </optgroup>';
                                            } else if ($orden == 'noAbiertos') {//Només missatges sense obrir
                                                echo '<optgroup label="Selección">
                                                        <option value="recientes">Más recientes primero</option>
                                                        <option value="noRecientes">Menos recientes primero</option>
                                                        <option value="abiertos">Leídos</option>
                                                        <option value="noAbiertos" selected>No leídos</option>
                                                    </optgroup>';
                                            } else {//Missatges més recents primer
                                                echo '<optgroup label="Selección">
                                                        <option value="recientes" selected>Más recientes primero</option>
                                                        <option value="noRecientes">Menos recientes primero</option>
                                                        <option value="abiertos">Leídos</option>
                                                        <option value="noAbiertos">No leídos</option>
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
                                if ($orden == 'abiertos') {
                                    //Selecionam els missatges oberts
                                    $consultP = "SELECT assumpte, data, IdMissatge FROM missatge WHERE missatge.username = '".$_SESSION['username']."' AND estatMissatge = 1 ORDER BY data DESC";
                                    $resultP = mysqli_query($con, $consultP);
                                    
                                    //echo $fila1['assumpte'];
                                    if(!isset($fil)){
                                        echo '<center><div class="padding"></div><h6><i class="bi-envelope-x" style="font-size: 0.9rem;"></i>&nbsp&nbspNo tienes mensajes abiertos</h6><div class="padding"></div></center>';
                                    }else {
                                        echo '
                                        <thead>
                                            <tr style="background-color: black; color: white;">
                                                <th>Ver mensaje</th>
                                                <th>Asunto</th>
                                                <th>Fecha</th>
                                            </tr>
                                        </thead>                                    
                                        ';
                                        //Omplim la taula amb els resultats
                                        if (mysqli_num_rows($resultP) > 0) {
                                            while ($fila1 = mysqli_fetch_assoc($resultP)) {
                                                $assumpte = $fila1['assumpte'];
                                                $data = $fila1['data'];
                                                $id = $fila1['IdMissatge'];

                                                echo '
                                                <tbody>
                                                <tr>
                                                    <td> 
                                                        <a href="veureMissatge.php?id='.$id.'" class="btn btn-outline-primary mx-3">
                                                            <i class="bi-envelope-open" title="Ver mensaje"  style="font-size: 0.9rem;"></i>
                                                        </a>  
                                                    </td>
                                                    <td>' . $assumpte . '</td>
                                                    <td>' . $data . '</td>
                                                    </tr>
                                                </tbody>
                                                ';
                                            }
                                        }
                                    }
                                } else if ($orden == 'noAbiertos') {
                                    //Seleccionam els missatges no oberts
                                    $consultP = "SELECT assumpte, data, IdMissatge FROM missatge WHERE missatge.username = '".$_SESSION['username']."' AND estatMissatge = 0 ORDER BY data DESC";
                                    $resultP = mysqli_query($con, $consultP);
                                    if(!isset($filNo)){
                                        echo '<center><div class="padding"></div><h6><i class="bi-envelope-x" style="font-size: 0.9rem;"></i>&nbsp&nbspNo tienes mensajes sin abrir</h6><div class="padding"></div></center>';
                                    }else {
                                        echo '
                                        <thead>
                                            <tr style="background-color: black; color: white;">
                                                <th>Ver mensaje</th>
                                                <th>Asunto</th>
                                                <th>Fecha</th>
                                            </tr>
                                        </thead>                                    
                                        ';
                                        //Omplim la taula amb els resultats
                                        if (mysqli_num_rows($resultP) > 0) {
                                            while ($fila1 = mysqli_fetch_assoc($resultP)) {
                                                $assumpte = $fila1['assumpte'];
                                                $data = $fila1['data'];
                                                $id = $fila1['IdMissatge'];

                                                echo '
                                                <tbody>
                                                <tr>
                                                    <td> 
                                                        <a href="veureMissatge.php?id='.$id.'" class="btn btn-primary mx-3">
                                                            <i class="bi-envelope" title="Ver mensaje"  style="font-size: 0.9rem;"></i>
                                                        </a>  
                                                    </td>
                                                    <td>' . $assumpte . '</td>
                                                    <td>' . $data . '</td>
                                                    </tr>
                                                </tbody>
                                                ';
                                            }
                                        }
                                    }
                                } else if ($orden == 'noRecientes') {
                                    //Seleccionam els missatges i els ordenam de manera ascendent
                                    $consultP = "SELECT assumpte, data, IdMissatge, estatMissatge FROM missatge WHERE missatge.username = '".$_SESSION['username']."' ORDER BY data ASC";
                                    $resultP = mysqli_query($con, $consultP);
                                    if(!isset($filTots)){
                                        echo '<center><div class="padding"></div><h6><i class="bi-envelope-x" style="font-size: 0.9rem;"></i>&nbsp&nbspNo tienes mensajes</h6><div class="padding"></div></center>';
                                    }else {
                                        echo '
                                        <thead>
                                            <tr style="background-color: black; color: white;">
                                                <th>Ver mensaje</th>
                                                <th>Asunto</th>
                                                <th>Fecha</th>
                                            </tr>
                                        </thead>                                    
                                        ';
                                        //Omplim la taula amb els resultats
                                        if (mysqli_num_rows($resultP) > 0) {
                                            while ($fila1 = mysqli_fetch_assoc($resultP)) {
                                                $assumpte = $fila1['assumpte'];
                                                $data = $fila1['data'];
                                                $id = $fila1['IdMissatge'];
                                                $estat = $fila1['estatMissatge'];

                                                if($estat == 1){//Si ja està obert
                                                    echo '
                                                    <tbody>
                                                    <tr>
                                                        <td> 
                                                            <a href="veureMissatge.php?id='.$id.'" class="btn btn-outline-primary mx-3">
                                                            
                                                                <i class="bi-envelope-open" title="Ver mensaje"  style="font-size: 0.9rem;"></i>
                                                            </a>  
                                                        </td>
                                                        <td>' . $assumpte . '</td>
                                                        <td>' . $data . '</td>
                                                        </tr>
                                                    </tbody>
                                                    ';
                                                } else {//Si està tancat
                                                    echo '
                                                    <tbody>
                                                    <tr>
                                                        <td> 
                                                            <a href="veureMissatge.php?id='.$id.'" class="btn btn-primary mx-3">
                                                        
                                                                <i class="bi-envelope" title="Ver mensaje"  style="font-size: 0.9rem;"></i>                                                      
                                                            
                                                            </a>  
                                                        </td>
                                                        <td>' . $assumpte . '</td>
                                                        <td>' . $data . '</td>
                                                        </tr>
                                                    </tbody>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                }else {
                                    //Seleccionam els missatges i els odenam de forma descendent
                                    $consultP = "SELECT assumpte, data, IdMissatge, estatMissatge FROM missatge WHERE missatge.username = '".$_SESSION['username']."' ORDER BY data DESC";
                                    $resultP = mysqli_query($con, $consultP);
                                    if(!isset($filTots)){
                                        echo '<center><div class="padding"></div><h6><i class="bi-envelope-x" style="font-size: 0.9rem;"></i>&nbsp&nbspNo tienes mensajes</h6><div class="padding"></div></center>';
                                    }else {
                                        echo '
                                        <thead>
                                            <tr style="background-color: black; color: white;">
                                                <th>Ver mensaje</th>
                                                <th>Asunto</th>
                                                <th>Fecha</th>
                                            </tr>
                                        </thead>                                    
                                        ';
                                        //Omplim la taula amb els resultats
                                        if (mysqli_num_rows($resultP) > 0) {
                                            while ($fila1 = mysqli_fetch_assoc($resultP)) {
                                                $assumpte = $fila1['assumpte'];
                                                $data = $fila1['data'];
                                                $id = $fila1['IdMissatge'];
                                                $estat = $fila1['estatMissatge'];

                                                if($estat == 1){//Si està obert
                                                    echo '
                                                    <tbody>
                                                    <tr>
                                                        <td> 
                                                            <a href="veureMissatge.php?id='.$id.'" class="btn btn-outline-primary mx-3">
                                                            
                                                                <i class="bi-envelope-open" title="Ver mensaje"  style="font-size: 0.9rem;"></i>
                                                            </a>  
                                                        </td>
                                                        <td>' . $assumpte . '</td>
                                                        <td>' . $data . '</td>
                                                        </tr>
                                                    </tbody>
                                                    ';
                                                } else {//Si està tancat
                                                    echo '
                                                    <tbody>
                                                    <tr>
                                                        <td> 
                                                            <a href="veureMissatge.php?id='.$id.'" class="btn btn-primary mx-3">
                                                        
                                                                <i class="bi-envelope" title="Ver mensaje"  style="font-size: 0.9rem;"></i>                                                      
                                                            
                                                            </a>  
                                                        </td>
                                                        <td>' . $assumpte . '</td>
                                                        <td>' . $data . '</td>
                                                        </tr>
                                                    </tbody>
                                                    ';
                                                }
                                            }
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

    <script> //Script que ens actualitza la pàgina ordenant els missatges
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