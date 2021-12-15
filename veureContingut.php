<?php
    include "connection.php";
    session_start();
    if(!isset($_SESSION['username']) and $_SESSION['estatContracte']==0 or $_SESSION['estatContracte']==null){
        header("Location: editarContracteForm.php");
        die();
    }

    $query = "SELECT * FROM contingut WHERE IdContingut=".$_GET['id'] ; 
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_array($result);
    $peli = $row['html'];
    $titol = $row['titol'];
    
    
    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width">
    <title>PelisTube - Tu plataforma de streaming</title> <!--Título que aparecerá en la pestaña del navegador-->
    <link rel="stylesheet" href="css/bootstrap.min.css"/> <!-- Importamos hoja de estilos de bootrstrap-->
    <link rel="stylesheet" href="styles.css"/> <!-- Nuestra propia hoja de estilos-->
    <link rel="shortcut icon" href="img/icon.png" /> <!-- Icono de la pestaña-->
</head>
    <body class="bg-dark">
        <header>
            <?php include "navbar.php"; ?>
        </header>
        <section class="bg-dark">
            <div class="bg-dark"></div>
            
                <div class=" p-4 mb-5 bg-dark rounded">
                    <div class="bg-dark ">
                    
                        <div class="row text-white">
                            <div class="col-md-2 m-md-auto pb-4">
                                <center>
                                    <h5> 
                                        <?php echo $titol ?>
                                    </h5>
                                </center>
                            </div>
                        </div>

                        <div class="container-xxl">                                
                            <center>
                                <?php echo '<iframe width="1080" height="608" src='.$peli.'?autoplay=1 title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'?>
                            </center>   
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
