<?php
    include "connection.php";
    session_start();
    //Si un usuari que no és l'administrador no té contracte o el té inactiu, redirigim l'usuari a editarContracteForm
    if(isset($_SESSION['username']) and $_SESSION['administrador']==0 and ($_SESSION['estatContracte']==0 or $_SESSION['estatContracte']==null)){
        header("Location: editarContracteForm.php");
        die();
    }

    //Seleccionam el contingut que volem visualitzar
    $query = "SELECT * FROM contingut WHERE IdContingut=".$_GET['id']; 
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_array($result);
    $peli = $row['link'];
    $titol = $row['titol'];
    $id = $row['IdContingut'];
    $cat = $row['nomCat'];
    $vis = $row['visible'];

    if($visible == 0){
        header("Location: llistarContinguts.php?msg=14");
        die();
    }

    //Seleccionam el tipus al qual pertany
    $query3 = "SELECT * FROM r_tipus_contingut JOIN tipus ON (tipus.IdTipus = r_tipus_contingut.IdTipus AND r_tipus_contingut.IdContingut = '".$id."')"; 
    $result3 = mysqli_query($con,$query3);
    
    if(isset($_SESSION['IdContracte'])){
        $query2 = "SELECT * from contingutfavorits where IdContracte='".$_SESSION['IdContracte']."' and IdContingut='".$id."'"; // Per comprovar si ja està a la llista de favorits
        $result2 = mysqli_query($con,$query2);
        $fav = mysqli_fetch_array($result2);
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="img/icon.png" /> <!-- Icono de la pestaña-->
</head>
    <body class="bg-dark">
        <header>
            <?php include "navbar.php";
            include "missatge.php"; ?>
        </header>
        <section>
            <div class="container">
                <div class="padding"><br></div>
                    <div class="col-md-auto">
                        <div class="shadow-lg p-4 mb-5 bg-body rounded ">
                            <center>
                                <div class="row gap-2">
                                    <div class="col mt-2 mb-4">
                                        <h3> <!--Imprimim el titol del contingut-->
                                            <?php echo $titol ?>
                                        </h3>
                                    </div>
                                </div>
                                <div class="container">                                
                                    <!--Mostram el video del contingut-->
                                    <?php echo '<iframe width="1080" height="608" src='.$peli.'?autoplay=1 title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'?>
                                      
                                </div>
                                <div class= "mt-4  mb-3">
                                    
                                    <?php 
                                    if($_SESSION['administrador']==1){//Si és administrador posam els botons d'editar contingut i eliminar contingut
                                        echo   '<div class="padding"></div>
                                                <div class="row">
                                                        <div class="col">
                                                        <a href="editarContingutForm.php?nomPelicula='.$titol.'" class="btn btn-outline-success mx-3">
                                                            <i class="bi-pencil-square" title="Editar contenido" style="font-size: 0.9rem;"></i>
                                                        </a>
                                                        <a href="eliminarContingut.php?id='.$id.'&redir=llistarContinguts.php" onclick="return confirmDelete()" class="btn btn-outline-danger mx-3">
                                                            <i class="bi-trash" title="Eliminar contenido"  style="font-size: 0.9rem;"></i>
                                                        </a> 
                                                    </div>
                                                </div>
                                    
                                    </div>';  
                                    } else if(isset($fav)){ // Imprimim el botó per eliminar favorit
                                            echo '<a href="eliminarContingutFavorit.php?id='.$id.'&redir=veureContingut.php" class="btn btn-success" title="Eliminar de favoritos"><i class="bi-star-fill" style="font-size: 0.9rem;"></i></a>';
                                                            
                                    }  else if (isset($_SESSION['IdContracte'])) { // Imprimim el botó per afegir favorit
                                            echo '<a href="afegirContingutFavorit.php?id='.$id.'&redir=veureContingut.php" class="btn btn-outline-success" title="Agregar a favoritos"><i class="bi-star" style="font-size: 0.9rem;"></i></a>';
                                        }
                                    ?>
                                
                            </center>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-5">
                                    <!--Mostram la categotia a la qual pertany-->
                                    <?php echo "<h5 class = 'mb-3'>La categoría a la que pertenece este contenido es ".$cat." y está recomendado para:</h5>";?>
                                    
                                    <?php //Mostram el tipus al qual pertany
                                        if (mysqli_num_rows($result3) > 0) {
                                            while ($fila1 = mysqli_fetch_assoc($result3)) {
                                                echo "<h6 class= 'ms-3'> " . $fila1['edat'] . "</h6>";
                                            }
                                        }
                                    ?>     
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
       

        <!-- Frameworks -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>
