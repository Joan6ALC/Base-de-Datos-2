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
    if($password1!=$password2){ // Si no coincideixen, error 1
        header("Location: registerform.php?msg=18&name=$name&surname1=$surname1&surname2=$surname2&dob=$dob&username=$username");
        die();
    }

    include "connection.php"; // Connexió a bd

    // Comprovam si l'username triat ja està en ús
    $query = 'SELECT username FROM persona WHERE username="'.$username.'"';
    $result=mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);


    if (isset($row['username'])){ // Si ja existeix l'usuari, error 2
        header("Location: registerform.php?msg=19&name=$name&surname1=$surname1&surname2=$surname2&dob=$dob&username=$username");
        die();
    }

    // Calcula l'edat d'un usuari en el moment actual i li assignam un tipus de contingut que pot veure segons l'edat
    $firstDate  = new DateTime($dob);
    $secondDate = new DateTime($date);
    $intvl = $firstDate->diff($secondDate);
    $edat=$intvl->y;

    //echo $intvl->y . " year, " . $intvl->m." months and ".$intvl->d." day"; 
    if($edat<9){
        $tipus=1;
    } else if($edat<18){
        $tipus=2;
    } else {
        $tipus=3;
    }

    // Inserció del nou usuari a la taula persona
    $hash=crypt($password1,"");
    $query = "INSERT INTO persona(dataAlta, username, password, nom, llinatge1, llinatge2, dataNaixament, administrador, IdTipus) VALUES ('".$date."','".$username."', '".$hash."', '".$name."', '".$surname1."', '".$surname2."', '".$dob."', false, $tipus)";
    mysqli_query($con, $query); // Registram el nou usuari
    echo $query;

    // L'usuari s'ha registrat correctament, li permetem iniciar sessió
    header("Location: index.php?msg=17"); // Redirigim a l'usuari a la pàgina principal amb missatge d'èxit
    die();
?>