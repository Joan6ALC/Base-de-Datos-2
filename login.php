<?php 
    // Recollida de paràmetres del formulari
    $username= $_POST['username'];
    $password= $_POST['password'];

    // Connexió a bd
    include "conexion.php";
    $consulta = "SELECT * FROM persona where username='".$username."'";

    $resultado=mysqli_query($con, $consulta); 

    
    $registro = mysqli_fetch_array($resultado); // Obtenim la primera fila de la consulta (només n'hi ha una)
    $passbd = $registro['password']; // Conté la contrasenya encriptada emmegatzemada a la base de dades

    if(!password_verify($password, $passbd)){ // Compara la contrasenya introduïda (plain) amb la guardada a la base de dades (encriptada)
        // PASSWORD INCORRECTE (Com mostram un html diferent si es produeix aquest error?) *****
        // posible sol echo '<html> .... </html>
        echo "<center>Los datos introducidos no son correctos</center>";
        header("Location: index.html");
        
    } else {
        session_start();
            
        $_SESSION['username']= $username; // Establim la variable de sessió (username)
        $_SESSION['administrador']=$registro['administrador']; // Si es administrador o no (administrador)
    }

    mysqli_close($con);
// Mostrar menú d'opcions
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
            <div class="container">
                <div class="row ">
                    <div class="col-md-1"></div> 
                    <div class="col-md-10">
                        <div class="shadow-lg p-4 mb-5 bg-body rounded">
                            <div class="d-grid gap-0">
                                <center><h2>Hola 
                                    <?php // BENVINGUDA: Imprimir el nom del usuari
                                    echo "@".$_SESSION['username'].",";
                                    ?>
                                </h2>
                                <br>

                                <div class="row">
                                    <div class="col-md-6"> <!-- MISSATGES -->
                                        <img src="img/mensaje.png" height="24" width="24">
                                        <?php // MISSATGES: Comprovam si tenim missatges sense llegir
                                            include "conexion.php";

                                            $query = "select count(*) from persona join missatge on persona.username='".$username."' AND missatge.username='".$username."'";
                                            $fila = mysqli_query($con,$query);
                                            $registre = mysqli_fetch_array($fila);

                                            if($registre['count(*)']>0){
                                                echo "Tienes ".$registre['count(*)']." mensaje(s) nuevos: <br>";
                                                $query = "select * from persona join missatge on persona.username='".$username."' AND missatge.username='".$username."'";
                                                $fila = mysqli_query($con,$query);

                                                while($registre = mysqli_fetch_array($fila)){ // Obtenim la primera fila de la consulta (només n'hi ha una)
                                                    echo $registre['data']." - ".$registre['assumpte']; 
                                                    echo '<div class="padding"><a class="btn btn-outline-danger btn-sm" href="index.html" role="button">Ver mensajes</a></div>';
                                                }
                                            } else {
                                                echo "No tienes mensajes nuevos<br>";
                                            }
                                            mysqli_close($con);
                                        ?>
                                    </div>
                                    <div class="col-md-6"> <!-- FACTURES -->
                                        <img src="img/factura.png" height="22" width="22">
                                        <?php
                                            include "conexion.php";

                                            $query = "select * from contracte join factura on contracte.idContracte=factura.idContracte and username='".$username."'";
                                            $fila = mysqli_query($con,$query);
                                            if($registre = mysqli_fetch_array($fila)){
                                                echo 'Consulta tu última factura:';
                                                echo "<br>".$registre['dataInici']." al ".$registre['dataFinal']." - Importe: ".$registre['import']."€";
                                                if ($registre['dataPagament']==null){
                                                    echo '<div class="padding"><a class="btn btn-outline-danger btn-sm px-2" href="index.html" role="button">Pagar</a><div>';
                                                } else {
                                                    echo '<div class="padding"><a class="btn btn-outline-danger btn-sm px-2" href="index.html" role="button">Ver</a></div>';
                                                }

                                            } else {
                                                echo "No tienes todavía ninguna factura disponible";
                                            }
                                            mysqli_close($con);
                                        ?>
                                    </div>
                                </div>
                                </center>
                                <br>
                                <h5>Novedades</h5>
                                <div class="row">
                                    <div class="card" style="width: 18rem;">
                                        <img class="card-img-top" src="./img/icon.png" alt="avatar.png">
                                        <div class="card-body">
                                            <h6 class="Pelicula">Avatar</h6>
                                            <p class="card-text">Sinopsis de la película Avatar</p>
                                            <center><a href="#" class="btn btn-danger btn-sm">Ver película</a></center>
                                        </div>
                                    </div> 
                                    <div class="card" style="width: 18rem;">
                                        <img class="card-img-top" src="./img/icon.png" alt="avatar.png">
                                        <div class="card-body">
                                            <h6 class="Pelicula">Avatar</h6>
                                            <p class="card-text">Sinopsis de la película Avatar</p>
                                            <center><a href="#" class="btn btn-danger btn-sm">Ver película</a></center>
                                        </div>
                                    </div> 
                                    <div class="card" style="width: 18rem;">
                                        <img class="card-img-top" src="./img/icon.png" alt="avatar.png">
                                        <div class="card-body">
                                            <h6 class="Pelicula">Avatar</h6>
                                            <p class="card-text">Sinopsis de la película Avatar</p>
                                            <center><a href="#" class="btn btn-danger btn-sm">Ver película</a></center>
                                        </div>
                                    </div> 
                                </div>
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
