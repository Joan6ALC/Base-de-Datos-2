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
    <title>PelisTube - Tu plataforma de streaming</title> <!--Título que aparecerá en la pestaña del navegador-->
    <link rel="stylesheet" href="css/bootstrap.min.css"/> <!-- Importamos hoja de estilos de bootrstrap-->
    <link rel="stylesheet" href="styles.css"/> <!-- Nuestra propia hoja de estilos-->
    <link rel="shortcut icon" href="img/icon.png" /> <!-- Icono de la pestaña-->
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
                            <div class="d-grid gap-0">
                                
                            <center>
                            <?php 

                            include "connection.php";

                            $consulta = "SELECT * FROM categoria";

                            $resultado=mysqli_query($con, $consulta); 

                            echo "<table align='center'>";
                            echo "<tr><td>Categoria</td><td colspan='10' align='center'>Acción</td></tr>";

                            while ($categoria = mysqli_fetch_array($resultado)) {
                                $fav = '<a href="afegirCategoriaFavorita.php?categoria='.$categoria['nomCat'].'"><3</a>';   
                                echo "<tr><td>".$categoria['nomCat']."</td><td>".$fav."</td><td>";
                            }

                        echo "</table>";

                        mysqli_close($con);
                        // Mostrar menú d'opcions
                        ?>
                                
                                </center>
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