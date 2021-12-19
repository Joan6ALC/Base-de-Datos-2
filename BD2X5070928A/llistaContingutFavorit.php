<?php session_start();
    if(!isset($_SESSION['username'])){
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
        <?php include "navbar.php";
        include "missatge.php";
        ?>
    </header>

        <section>
            <div class="padding"></div>
            <div class="container">
                <div class="row ">
                    <div class="col-md-1"></div>                    
                    <div class="col-md-10">
                        <div class="shadow-lg p-4 mb-5 bg-body rounded">
                            <div class="row">
                            <h5>Tus contenidos favoritos
                            
                            </h5></div>

                            <div class="padding"></div>
                            <center>
                            <div class="row justify-content-center gap-2">                                
                                <?php
                                    include "connection.php";
                                    $query = "SELECT * from (contingutfavorits JOIN contingut ON contingutfavorits.IdContingut = contingut.IdContingut)
                                    JOIN categoria ON categoria.nomCat = contingut.nomCat AND categoria.visible = 1";
                                    $result = mysqli_query($con,$query);
                                    while($row = mysqli_fetch_array($result)){
                                        if(isset($_SESSION['IdContracte'])){
                                            $query2 = "SELECT * from contingut where IdContingut='".$row['IdContingut']."'"; // Per comprovar si ja està a la llista de favorits
                                            $result2 = mysqli_query($con,$query2);
                                            $data = mysqli_fetch_array($result2);
                                        }
                                        if($data['visible'==1]){
                                            echo   '<div class="col">
                                                    <div class="card" style="width: 12rem;">
                                                        <img class="card-img-top" src=".'.$data['camiFoto'].'" alt="'.$data['titol'].'.png" height="250">
                                                        <div class="card-body">
                                                            <center><h6>'.$data['titol'].'</h6>
                                                            <div class="padding"></div>
                                                            <a href="veureContingut.php?id='.$data['IdContingut'].'" class="btn btn-danger btn-sm">Ver película</a> ';
                                            echo            '<a href="eliminarContingutFavorit.php?id='.$data['IdContingut'].'&redir=llistaContingutFavorit.php" 
                                                                class="btn btn-success btn-sm" title="Eliminar de favoritos">
                                                                    <i class="bi-star-fill" style="font-size: 0.9rem;"></i></a></center>';
                                        }
                                        
                                        echo        '</div>
                                                    </div>
                                                </div>';
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
            PelisTube &copy; 2021
        </footer>


    <!-- Frameworks -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>