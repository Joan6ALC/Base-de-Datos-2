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
        include "missatge.php";
        ?>
    </header>

    <section>
            <div class="padding"></div>
            <center>
                <div class="container">
                    <div class="col-md-1"></div> 
                        <div class="col-md-10">
                            <div class="shadow-lg p-4 mb-5 bg-body rounded">
                                <div class="d-grid gap-0">

        <?php
        include "connection.php";
        $Categoria = $_GET['id'];
        $query = "SELECT * from categoria WHERE nomCat = '".$Categoria."' ";
                                    $result = mysqli_query($con,$query);
                                    $row = mysqli_fetch_array($result);

                                    
                                        if(isset($_SESSION['IdContracte'])){
                                            $query2 = "SELECT * from categoriafavorits where IdContracte='".$_SESSION['IdContracte']."' AND nomCat='".$row['nomCat']."'"; // Per comprovar si ja està a la llista de favorits
                                            $result2 = mysqli_query($con,$query2);
                                            if($result2){
                                                $fav = mysqli_fetch_array($result2);
                                            }
                                            
                                        
                                        }
                                        echo  '<div class="row justify-content-center">
                                                <div class="col">       
                                                    <div class="card style=width: 65rem ";">
                                                        <div class="card-body">
                                                            <center><h6>'.$row['nomCat'].'</h6>
                                                            <div class="padding"></div>';

                                        if(isset($fav)){ // Imprimim el botó per eliminar favorit
                                            echo            '<a href="eliminarCategoriaFavorit.php?id='.$row['nomCat'].'&redir=llistaContingutCat.php" class="btn btn-success btn-sm"  title="Eliminar de favoritos"><i class="bi-star-fill" style="font-size: 0.9rem;"></i></a></center>';
                                            
                                        }  else if (isset($_SESSION['IdContracte'])) { // Imprimim el botó per afegir favorit
                                            echo            '<a href="afegirCategoriaFavorita.php?id='.$row['nomCat'].'&redir=llistaContingutCat.php" class="btn btn-outline-success btn-sm"  title="Agregar a favoritos"><i class="bi-star" style="font-size: 0.9rem;"></i></a></center>';
                                        }if($_SESSION['administrador']==1){
                                            echo           '<div class="padding"></div>
                                                            <div class="row gap-1">
                                                            <div class="col">
                                                                    <a href="editarCategoriaForm.php?" class="btn btn-outline-success btn-sm">
                                                                        <i class="bi-pencil-square" title="Editar contenido" style="font-size: 0.9rem;"></i>
                                                                    </a>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>';
                                        } 
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
                                                            echo    '<a href="eliminarContingutFavorit.php?id='.$row2['IdContingut'].'&nomCat='.$row['nomCat'].'&redir=llistaContingutCat.php" class="btn btn-success btn-sm" title="Eliminar de favoritos"><i class="bi-star-fill" style="font-size: 0.9rem;"></i></a></center>
                                                                </div>
                                                            </div>
                                                            </div>';
                                                                            
                                                        }  else if (isset($_SESSION['IdContracte'])) { // Imprimim el botó per afegir favorit
                                                            echo            '<a href="afegirContingutFavorit.php?id='.$row2['IdContingut'].'&nomCat='.$row['nomCat'].'&redir=llistaContingutCat.php" class="btn btn-outline-success btn-sm" title="Agregar a favoritos"><i class="bi-star" style="font-size: 0.9rem;"></i></a></center>
                                                                </div>
                                                            </div>
                                                            </div>';
                                                        }  if($_SESSION['administrador']==1){
                                                            echo           '<div class="padding"></div>
                                                                            <div class="row gap-1">
                                                                            <div class="col">
                                                                                    <a href="editarContingutForm.php?id='.$row2['IdContingut'].'" class="btn btn-outline-success btn-sm">
                                                                                        <i class="bi-pencil-square" title="Editar contenido" style="font-size: 0.9rem;"></i>
                                                                                    </a>
                                                                                    <a href="eliminarContingut.php?id='.$row2['IdContingut'].'&redir=llistarContinguts.php" onclick="return confirmDelete()" class="btn btn-outline-danger btn-sm">
                                                                                        <i class="bi-trash" title="Eliminar contenido"  style="font-size: 0.9rem;"></i>
                                                                                    </a> 
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>';  
                                                        }
                                                }         
                                
                                            
                                            echo '</div>';
                                            echo '<div class="padding"></div>';
                                    
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