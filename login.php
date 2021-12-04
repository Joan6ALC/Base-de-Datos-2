<?php session_start();
    // Recollida de paràmetres del formulari
    $username= $_POST['username'];
    $password= $_POST['password'];

    // Connexió a bd
    include "connection.php";
    $query = "SELECT * FROM persona where username='".$username."'";
    $result=mysqli_query($con, $query); 

    
    $row = mysqli_fetch_array($result); // Obtenim la primera fila de la consulta (només n'hi ha una)
    $passbd = $row['password']; // Conté la contrasenya encriptada emmegatzemada a la base de dades

    if(!password_verify($password, $passbd)){ // Compara la contrasenya introduïda (plain) amb la guardada a la base de dades (encriptada)
        // PASSWORD INCORRECTE (Com mostram un html diferent si es produeix aquest error?) *****
        // posible sol echo '<html> .... </html>
        echo "<center>Los datos introducidos no son correctos</center>";
        header("Location: index.html");
        
    } else {
        //session_start();
        $_SESSION['username']= $username; // Establim la variable de sessió (username)
        $_SESSION['administrador']=$row['administrador']; // Si es administrador o no (administrador)
    }

    mysqli_close($con);
// Mostrar menú d'opcions
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width">
    <title>Bienvenido <?php echo "@".$_SESSION['username'] ?></title> <!--Título que aparecerá en la pestaña del navegador-->
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
                                <center><h2>Hola  <!-- BENVINGUDA: Imprimir el nom del usuari -->
                                    <?php 
                                    echo "@".$_SESSION['username'].",";
                                    ?>
                                </h2>
                                </center>
                                <div class="padding"></div>
                                <div class="padding"></div>

                                <div class="row justify-content-center gap-2">
                                    <div class="col"> <!-- MISSATGES -->
                                        <h5>Bandeja de entrada</h5>
                                        <div class="padding"></div>
                                        <center>
                                        <div class="card" style="width: 26rem;">
                                            <div class="card-body">
                                                <img src="img/mensaje.png" height="24" width="24">
                                                <div class="padding"></div>
                                                <?php // MISSATGES: Comprovam si tenim missatges sense llegir
                                                    include "connection.php";

                                                    $query = "select count(*) from missatge where username='".$username."'";
                                                    $result = mysqli_query($con,$query);
                                                    $row = mysqli_fetch_array($result);

                                                    if($row['count(*)']>0){
                                                        echo '<h6>Tienes '.$row['count(*)']." mensaje(s) nuevos:</h6>";
                                                        $query = "select * from missatge where username='".$username."'";
                                                        $result = mysqli_query($con,$query);
                                                        
                                                        while($row = mysqli_fetch_array($result)){ // Obtenim la primera fila de la consulta
                                                            echo $row['data']." - ".$row['assumpte']."<br>"; 
                                                        }
                                                        echo '<div class="padding"></div><a href="#" class="btn btn-danger btn-sm">Ver mensajes</a>';
                                                    } else {
                                                        echo "<h6>No tienes mensajes nuevos</h6>";
                                                    }
                                                    mysqli_close($con);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    </center>
                                    <div class="col"> <!-- FACTURES -->
                                        <h5>Facturación</h5>
                                        <div class="padding"></div>
                                        <center>
                                        <div class="card" style="width: 26rem;">
                                            <div class="card-body">
                                                <img src="img/factura.png" height="22" width="22">
                                                <div class="padding"></div>
                                                <?php
                                                    include "connection.php";

                                                    $query = "select * from contracte join factura on contracte.idContracte=factura.idContracte and username='".$username."'";
                                                    $result = mysqli_query($con,$query);
                                                    if($row = mysqli_fetch_array($result)){
                                                        echo '<h6>Consulta tu última factura:</h6>';
                                                        echo $row['dataInici']." al ".$row['dataFinal']." - Importe: ".$row['import'].'€';
                                                        if ($row['dataPagament']==null){
                                                            echo '<div class="padding"></div><a href="#" class="btn btn-danger btn-sm">Pagar</a>';
                                                        } else {
                                                            echo '<div class="padding"></div><a href="#" class="btn btn-danger btn-sm">Vers</a>';;
                                                        }

                                                    } else {
                                                        echo '<h6>No tienes todavía ninguna factura disponible</h6>';
                                                    }
                                                    mysqli_close($con);
                                                ?>
                                                    
                                            </div>
                                        </div>
                                    </div>
                                    </center>
                                <br>
                                <div class="padding"></div>
                                <h5>Novedades</h5>
                                <center>
                                <div class="row justify-content-center gap-2"> <!-- NOVETATS SEGONS MISSATGES (segons les categories favorites) -->
                                <?php 
                                    include "connection.php";
                                    $query = "select * from missatge where username='".$_SESSION['username']."'" ; // Cerc els missatges de l'usuari
                                    $result = mysqli_query($con,$query);
                                    $i=0;

                                    if($row=mysqli_fetch_array($result)){
                                        
                                        while ($row and $i<8){
                                            $query = "select * from contingut where IdContingut='".$row['IdContingut']."'"; // Per cada missatge agaf el contingut i l'imprimesc
                                            $result2 = mysqli_query($con,$query);
                                            $contingut = mysqli_fetch_array($result2); 
                                            echo    '<div class="col">
                                                        <div class="card" style="width: 12rem;">
                                                            <img class="card-img-top" src=".'.$contingut['camiFoto'].'" alt="'.$contingut['titol'].'.png" height="250">
                                                            <div class="card-body">
                                                                <h6 class="Pelicula">'.$contingut['titol'].'</h6>
                                                                <div class="padding"></div>
                                                                <a href="#" class="btn btn-danger btn-sm">Ver película</a>
                                                            </div>
                                                        </div>
                                                    </div>';

                                            $i=$i+1;
                                            $row=mysqli_fetch_array($result);
                                        }
                                    } else {
                                        echo "<h6>Añade categorías favoritas para recibir recomendaciones</h6>";
                                    }

                                    mysqli_close($con);
                                ?>   
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
