<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    die();
}
// Connexió a bd
include "connection.php";

$titulo = $_POST['titulo'];
$html = $_POST['enlace'];
$nomCat = $_POST['nomCat'];
$tipoCont = $_POST['tipoCont'];
$nomFoto   = $_FILES['file']['name'];
$camiFoto = "/img/carteles/" . $nomFoto;

$html = str_replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/', $html);

if ($_FILES['file']['name'] != "") {
    $path = $_FILES['file']['name'];
    $pathto = 'img/carteles/' . $path;
    move_uploaded_file($_FILES['file']['tmp_name'], $pathto) or die("Could not copy file!");
} else {
    die("No file specified!");
}

$query = 'SELECT titol FROM contingut WHERE titol="' . $titulo . '"';
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);


if (isset($row['titol'])) {
    header("Location: afegirContingutForm.php?error=1");
    die();
}

$query = 'SELECT camiFoto FROM contingut WHERE camiFoto="' . $camiFoto . '"';
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);

if (isset($row['camiFoto'])) {
    header("Location: afegirContingutForm.php?error=2");
    die();
}

$query = "INSERT INTO contingut (titol, link, camiFoto, nomCat, visible) values ('$titulo','$html','$camiFoto','$nomCat', '1')"; //INSERTANDO VARIABLES DIRECTAMENTE
mysqli_query($con, $query);

foreach ($_POST['tipoCont'] as $tipoCont) {
    $query = 'SELECT IdTipus FROM tipus WHERE edat="' . $tipoCont . '"';
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    $idTipo = $row['IdTipus'];
    $query = 'SELECT IdContingut FROM contingut WHERE titol="' . $titulo . '"';
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    $idContingt = $row['IdContingut'];

    $query = "INSERT INTO r_tipus_contingut (IdTipus, IdContingut) values ('$idTipo','$idContingt')"; //INSERTANDO VARIABLES DIRECTAMENTE
    mysqli_query($con, $query);
}

header("Location: login.php?msg=3"); // Redirigim a l'usuari a la pàgina principal
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
        <?php include "navbar.php"; ?>
    </header>
    <!-- Frameworks -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>