<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    die();
}
// Connexió a bd
include "connection.php";

//Guardam els valors passats per paràmetre
$tituloAnt = $_POST['titolSelect'];

$titulo = $_POST['titulo'];
$html = $_POST['enlace'];
$nomCat = $_POST['nomCat'];
$tipoCont = $_POST['tipoCont'];
$visible = $_POST['visible'];
$nomFoto   = $_FILES['file']['name'];
$camiFoto = "/img/carteles/" . $nomFoto;

//Assignam la visibilitat
if (isset($visible) && $visible == '1'){
        $visible = 1;
}else{
        $visible = 0;
}
if ($tipoCont == '') {
    header("Location: editarContingutForm.php?error=3&nomPelicula=$tituloAnt");
    die();
}
//Seleccionam l'id del contingut a editar
$idContingut = "SELECT IdContingut FROM contingut WHERE titol = '".$tituloAnt."'";
$resId = mysqli_query($con, $idContingut);
$idCont = mysqli_fetch_array($resId);

//Seleccionam el cami de la foto
$camiFotoAnt = "SELECT camiFoto FROM contingut WHERE IdContingut = '".$idCont['IdContingut']."'";
$resCamiAnt = mysqli_query($con, $camiFotoAnt);
$camiAnt = mysqli_fetch_array($resCamiAnt);

//Pujam la nova foto si n'hi ha
if ($_FILES['file']['name'] != "") {
    $query = 'SELECT camiFoto FROM contingut WHERE camiFoto="' . $camiFoto . '"';
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);

    if (isset($row['camiFoto'])) {
        header("Location: editarContingutForm.php?error=2");
        die();
    }
    $path = $_FILES['file']['name'];
    $pathto = '/xampp/htdocs/pelistube/img/carteles/' . $path;
    unlink('/xampp/htdocs/pelistube'.$camiAnt['camiFoto'].'');
    move_uploaded_file($_FILES['file']['tmp_name'], $pathto) or die("Could not copy file!");
} else {
    $camiFoto = $camiAnt['camiFoto'];
}

//Seleccionam el titol del contingut a editar
$query = 'SELECT titol FROM contingut WHERE titol="' . $titulo . '" and IdContingut != "'.$idCont['IdContingut'].'" ';
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);

//Missatge d'error
if (isset($row['titol'])) {
    header("Location: editarContingutForm.php?error=1");
    die();
}

//Actualitzam els valors nous
$upd = "UPDATE contingut SET titol = '".$titulo."', link = '".$html."', camiFoto = '".$camiFoto."', nomCat = '".$nomCat."', visible = '".$visible."' WHERE IdContingut = '".$idCont['IdContingut']."'";
mysqli_query($con, $upd);


$query = 'SELECT IdContingut FROM contingut WHERE titol="' . $titulo . '"';
$result = mysqli_query($con, $query);
$idContingt = mysqli_fetch_array($result);
//Eliminam les relacions amb els tipus
$query = "DELETE FROM r_tipus_contingut WHERE IdContingut = '".$idContingt['IdContingut']."'"; 
mysqli_query($con, $query);

//Assignam les relacions amb els tipus
if(is_array($tipoCont)){
    foreach ($tipoCont as $valor) {
        $query = 'SELECT IdTipus FROM tipus WHERE edat="' . $valor . '"';
        $result = mysqli_query($con, $query);
        $idTipo = mysqli_fetch_array($result);
        $query = 'SELECT IdContingut FROM contingut WHERE titol="' . $titulo . '"';
        $result = mysqli_query($con, $query);
        $idContingt = mysqli_fetch_array($result);
        //Inserim la relacio a la base de dades
        $query = "INSERT INTO r_tipus_contingut (IdTipus, IdContingut) values ('".$idTipo['IdTipus']."','".$idContingt['IdContingut']."')";
        mysqli_query($con, $query);
    }
}
//Redirigim a l'usuari a la pàgina d'editar contingut
header("Location: editarContingutForm.php?msg=2&nomFoto=$nomFoto&idTipo=$idTipo&idCntingut=$idContingt");
die();

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
    <link rel="shortcut icon" href="img/icon.png" /> <!-- Icono de la pestaña-->
</head>

<body>
    <header>
        <?php include "navbar.php";?>
    </header>
    <!-- Frameworks -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>