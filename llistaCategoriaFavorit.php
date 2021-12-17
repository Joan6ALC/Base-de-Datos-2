<?php 

    session_start();
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
    <title>PelisTube - Tu plataforma de streaming</title>
    <!--Título que aparecerá en la pestaña del navegador-->
    <link rel="stylesheet" href="css/bootstrap.min.css" /> <!-- Importamos hoja de estilos de bootrstrap-->
    <link rel="stylesheet" href="styles.css" /> <!-- Nuestra propia hoja de estilos-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- iconos bootstrap -->
    <link rel="shortcut icon" href="img/icon.png" /> <!-- Icono de la pestaña-->
</head>

<body>

        <section>       
        
                                
    <header>
        <?php include "navbar.php";
        if(isset($_GET['msg'])){
            switch($_GET['msg']){
                case 1: // ELIMINACIÓ
                    echo    '<div class="padding"></div><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi-trash" style="font-size: 0.9rem;"></i>
                                &nbspContenido eliminado correctamente
                                <button type="button" style="background-color: transparent; border: 0px;" class="close" data-dismiss="alert" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                    break;
                
                case 2: // EDICIÓ
                    echo    '<div class="padding"></div><div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi-check2-square" style="font-size: 0.9rem;"></i>
                                &nbspContenido editado correctamente
                                <button type="button" style="background-color: transparent; border: 0px; class="close" data-dismiss="alert" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                    break;

                case 3: // ADDICIÓ
                    echo    '<div class="padding"></div><div class="alert alert-primary alert-dismissible fade show" role="alert">
                                <i class="bi-plus-circle" style="font-size: 0.9rem;"></i>
                                &nbspContenido añadido correctamente
                                <button type="button" style="background-color: transparent; border: 0px; class="close" data-dismiss="alert" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                    break;

                    case 4: // ELIMINACIÓ
                        echo    '<div class="padding"></div><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi-trash" style="font-size: 0.9rem;"></i>
                                    &nbspCategoría eliminado correctamente
                                    <button type="button" style="background-color: transparent; border: 0px;" class="close" data-dismiss="alert" aria-label="close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        break;
                    
                    case 5: // EDICIÓ
                        echo    '<div class="padding"></div><div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi-check2-square" style="font-size: 0.9rem;"></i>
                                    &nbspCategoría editado correctamente
                                    <button type="button" style="background-color: transparent; border: 0px; class="close" data-dismiss="alert" aria-label="close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        break;

                    case 6: // ADDICIÓ
                        echo    '<div class="padding"></div><div class="alert alert-primary alert-dismissible fade show" role="alert">
                                    <i class="bi-plus-circle" style="font-size: 0.9rem;"></i>
                                    &nbspCategoría añadido correctamente
                                    <button type="button" style="background-color: transparent; border: 0px; class="close" data-dismiss="alert" aria-label="close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        break;
                
                default: 
            }
        }
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
                            <h5>Tus categorías favoritos
                            
                            </h5></div>

                            <div class="padding"></div>
                            <center>
                            
        <?php
        include "connection.php";
        $query = "SELECT * from categoriafavorits ORDER BY nomCat ASC";
                                    $result = mysqli_query($con,$query);
                                    while($row = mysqli_fetch_array($result)){
                                        $query2 ="SELECT * from categoria WHERE nomCat = '".$row['nomCat']."'";
                                        $result2 = mysqli_query($con, $query2);
                                        $visible = mysqli_fetch_array($result2);
                                        if($visible['visible']==1){
                                        
                                        echo  '<div class="row justify-content-center">       
                                                    <div class="card style=width: 65rem ";">
                                                        <div class="card-body">
                                                            <center><h6>'.$row['nomCat'].'</h6>
                                                            <div class="padding"></div>';

                                                        echo    '<a href="eliminarCategoriaFavorit.php?id='.$row['nomCat'].'&redir=llistaCategoriaFavorit.php" class="btn btn-dark btn-sm"  title="Eliminar de favoritos"><i class="bi-star-fill" style="font-size: 0.9rem;"></i></a></center>';
                                            
                                        echo '</div>
                                        </div>
                                            </div>';
                                        echo   '<div class="row justify-content-center gap-2">';
                                        $query3 = "SELECT * from contingut WHERE nomCat='".$row['nomCat']."' AND visible = 1 ORDER BY titol ASC";
                                            $result3 = mysqli_query($con,$query3);
                                                while($row2 = mysqli_fetch_array($result3)){
                                                    if(isset($_SESSION['IdContracte'])){
                                                        $query4 = "SELECT * from contingutfavorits where IdContracte=".$_SESSION['IdContracte']." and IdContingut=".$row2['IdContingut'].""; // Per comprovar si ja està a la llista de favorits
                                                        $result4 = mysqli_query($con,$query4);
                                                        $fav2 = mysqli_fetch_array($result4);
                                                    }

                                        
                                        
                                                    echo   '
                                                    <div class="col">
                                                    <div class="padding"></div>
                                                    <div class="card" style="width: 12rem;">
                                                        <img class="card-img-top" src=".'.$row2['camiFoto'].'" alt="'.$row2['titol'].'.png" height="250">
                                                            <div class="card-body">
                                                            <center><h6>'.$row2['titol'].'</h6>
                                                            <div class="padding"></div>
                                                            <a href="veureContingut.php?id='.$row2['IdContingut'].'" class="btn btn-danger btn-sm">Ver película</a> ';
                                                        if(isset($fav2)){ // Imprimim el botó per eliminar favorit
                                                            echo    '<a href="eliminarContingutFavorit.php?id='.$row2['IdContingut'].'&redir=llistaCategoriaFavorit.php" class="btn btn-success btn-sm" title="Eliminar de favoritos"><i class="bi-star-fill" style="font-size: 0.9rem;"></i></a></center>
                                                                </div>
                                                            </div>
                                                            </div>';
                                                                            
                                                        }  else if (isset($_SESSION['IdContracte'])) { // Imprimim el botó per afegir favorit
                                                            echo            '<a href="afegirContingutFavorit.php?id='.$row2['IdContingut'].'&redir=llistaCategoriaFavorit.php" class="btn btn-outline-success btn-sm" title="Agregar a favoritos"><i class="bi-star" style="font-size: 0.9rem;"></i></a></center>
                                                                </div>
                                                            </div>
                                                            </div>';
                                                        }  else {
                                                                echo   
                                                                '</div>
                                                            </div>
                                                            </div>';
                                                        }         
                                
                                            }
                                            echo '</div>';
                                            echo '<div class="padding"></div>';
                                        }
                                    }
                                    mysqli_close($con);

        ?>
        </div>
        </div>
        </div>
        </div>
        </div>
                                </center>
        </div>

    </section>


    <footer>
            <div style="color: grey; font-size: 9px">PelisTube &copy; 2021</div>
        </footer>

        <style>
            body {
                background-image: url("img/background2.jpg");
                background-position:absolute;
            }
        </style>

    <!-- Frameworks -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>