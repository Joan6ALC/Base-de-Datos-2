<?php session_start();
    if(!isset($_SESSION['username']) or $_SESSION['administrador']==0){
        header("Location: index.php");
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"> <!-- Iconos bootstrap -->
    <link rel="shortcut icon" href="img/icon.png" /> <!-- Icono de la pestaña-->
    <script language="JavaScript" type="text/javascript" src="scripts.js"></script> <!-- Para importar mi hoja de scripts propia -->
</head>
    
    <body>
        <header>
            <?php include "navbar.php"; ?>
        </header>

        <section>
            <div class="padding"></div>
            <div class="container">
                <div class="row ">
                    <div class="col-md-1"></div>                    
                    <div class="col-md-10">
                        <div class="shadow-lg p-4 mb-5 bg-body rounded">
                            <div class="row">
                            <h5>Películas borradas</h5></div>

                            <div class="padding"></div>
                            <center>
                            <div class="row justify-content-center gap-2">                                
                                <?php
                                    include "connection.php";

                                    $query = "SELECT * from contingut where visible=0 ORDER BY RAND()";
                                    $result = mysqli_query($con,$query);
                                    if($row = mysqli_fetch_array($result)){
                                        while(isset($row)){
                                            if(isset($_SESSION['IdContracte'])){
                                                $query2 = "SELECT * from contingutfavorits where IdContracte=".$_SESSION['IdContracte']." and IdContingut=".$row['IdContingut'].""; // Per comprovar si ja està a la llista de favorits
                                                $result2 = mysqli_query($con,$query2);
                                                $fav = mysqli_fetch_array($result2);
                                            }

                                            echo   '<div class="col">
                                                        <div class="card" style="width: 12rem;">
                                                            <img class="card-img-top" src=".'.$row['camiFoto'].'" alt="'.$row['titol'].'.png" height="250">
                                                            <div class="card-body">
                                                                <center><h6>'.$row['titol'].'</h6>
                                                                <div class="padding"></div>
                                                                <a href="veureContingut.php?id='.$row['IdContingut'].'" class="btn btn-danger btn-sm">Ver película</a> ';
                                            
                                            if($_SESSION['administrador']==1){
                                                echo           '<div class="padding"></div>
                                                                <div class="row gap-1">
                                                                <div class="col">
                                                                        <a href="restaurarContingut.php?id='.$row['IdContingut'].'&redir=llistarBorrats.php" onclick="return confirmRestore()" class="btn btn-outline-warning btn-sm">
                                                                            <i class="bi-unlock" title="Restaurar"  style="font-size: 0.9rem;"></i>
                                                                        </a> 
                                                                    </div>
                                                                </div>';  
                                            }

                                            // Tancam els div :href="eliminarContingut.php?id='.$row['IdContingut'].'"
                                            echo        '</div>
                                                        </div>
                                                    </div>';
                                            $row = mysqli_fetch_array($result);
                                        }
                                    } else {
                                        echo '<div class="padding"></div><h6><i class="bi-trash" style="font-size: 0.9rem;"></i>&nbsp&nbspLa papelera está vacía</h6><div class="padding"></div>';  
                                    }

                                ?>
                                <div class="padding"></div>
                                <script>

                                </script>
                            </div>
                            </center>  
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer>
            <div style="color: grey; font-size: 9px">PelisTube &copy; 2021</div>
        </footer>

    <!-- Frameworks -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>