<?php 

    // Recollida de paràmetres
    $name= $_POST['name'];
    $surname1= $_POST['surname1'];
    $surname2= $_POST['surname2'];
    $dob = $_POST['dateofbirth'];
    $username = $_POST['username'];
    $password1 = $_POST['password'];
    $password2 = $_POST['password2'];
    $date = date('y-m-d'); // obtenim data local

    // Comprovam que les contrasenyes introduides coincideixen
    if($password1!=$password2){ // Si coincideixen, error 1
        header("Location: registerform.php?error=1&name=$name&surname1=$surname1&surname2=$surname2&dob=$dob&username=$username");
        die();
    }
    echo $dob;
    include "connection.php"; // Connexió a bd

    // Comprobam si l'username triat ja està en ús
    $query = 'select username from persona where username="'.$username.'"';
    $result=mysqli_query($con, $query);
    $register = mysqli_fetch_array($result);
    if (isset($register['username'])){ // Si ja existeix l'usuari, error 2
        header("Location: registerform.php?error=2&name=$name&surname1=$surname1&surname2=$surname2&dob=$dob&username=$username");
        die();
    }

    $hash=crypt($password1,"");
    $query = "insert into persona(dataAlta, username, password, nom, llinatge1, llinatge2, dataNaixament, administrador) values ('".$date."','".$username."', '".$hash."', '".$name."', '".$surname1."', '".$surname2."', '".$dob."', false)";
    mysqli_query($con, $query);

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
            <h1 class="title-large">Pelistube</h1>
            <h2 class="subtitle-large">Tu plataforma de streaming</h2>
        </header>

        <section>
            <div class="container">
                <div class="row ">
                    <div class="col-md-3"></div> <!--primera columna vacía-->
                    <div class="col-md-6">
                        <div class="shadow-lg p-4 mb-5 bg-body rounded">
                            <div class="d-grid gap-1">
                                <div class="registered-successfully">
                                <br>¡Enhorabuena! Ya formas parte de esta gran comunidad<br><br>
                                <a class="btn btn-outline-danger" href="index.html" role="button">Iniciar Sesión</a>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer>
            PelisTube &copy; 2021
        </footer>
    </body>
</html>