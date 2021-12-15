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

    include "connection.php"; // Connexió a bd

    // Comprobam si l'username triat ja està en ús
    $query = 'SELECT username FROM persona WHERE username="'.$username.'"';
    $result=mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);


    if (isset($row['username'])){ // Si ja existeix l'usuari, error 2
        header("Location: registerform.php?error=2&name=$name&surname1=$surname1&surname2=$surname2&dob=$dob&username=$username");
        die();
    }

    $firstDate  = new DateTime($dob);
    $secondDate = new DateTime($date);
    $intvl = $firstDate->diff($secondDate);
    $edat=$intvl->y;
    echo $edat;
    //echo $intvl->y . " year, " . $intvl->m." months and ".$intvl->d." day"; 
    if($edat<9){
        $tipus=1;
    } else if($edat<18){
        $tipus=2;
    } else {
        $tipus=3;
    }

    $hash=crypt($password1,"");
    $query = "INSERT INTO persona(dataAlta, username, password, nom, llinatge1, llinatge2, dataNaixament, administrador, IdTipus) VALUES ('".$date."','".$username."', '".$hash."', '".$name."', '".$surname1."', '".$surname2."', '".$dob."', false, $tipus)";
    mysqli_query($con, $query); // Registram el nou usuari
    echo $query;

    //L'usuari s'ha registrat correctament, li permetem iniciar sessió
    header("Location: index.php?msg=3"); // Redirigim a l'usuari a la pàgina principal
    die();
?>