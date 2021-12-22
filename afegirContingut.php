<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    die();
}
// Connexión con a base de datos
include "connection.php";
// Recogemos los valores a añadir
$titulo = $_POST['titulo'];
$html = $_POST['enlace'];
$nomCat = $_POST['nomCat'];
$tipoCont = $_POST['tipoCont'];
$nomFoto   = $_FILES['file']['name'];
$camiFoto = "/img/carteles/" . $nomFoto;

$idContingut = "SELECT IdContingut FROM contingut WHERE titol = '".$tituloAnt."'";
$resId = mysqli_query($con, $idContingut);
$idCont = mysqli_fetch_array($resId);

// Formateamos el enlace de youtube para que se pueda ver incrustado en la página
$html = str_replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/', $html);

// Tomamos el archivo y lo guardamos en la carpeta imagenes
if ($_FILES['file']['name'] != "") {
    $path = $_FILES['file']['name'];
    $pathto = 'img/carteles/' . $path;
    move_uploaded_file($_FILES['file']['tmp_name'], $pathto) or die("Could not copy file!");
} else {
    die("No file specified!");
}

// Comprobamos que no exista el valor para el título
$query = 'SELECT titol FROM contingut WHERE titol="' . $titulo . '"';
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);

// Si ya existe lanzamos un error de tipo 1
if (isset($row['titol'])) {
    header("Location: afegirContingutForm.php?error=1");
    die();
}

// Si no se ha seleccionado ningún contenido lanzamos un error de tipo 3
if ($tipoCont == '') {
    header("Location: afegirContingutForm.php?error=3");
    die();
}

// Comprobamos que no exista una foto con el mismo nombre
$query = 'SELECT camiFoto FROM contingut WHERE camiFoto="' . $camiFoto . '"';
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);

// Si ya exise, lanzamos un error de tipo 2
if (isset($row['camiFoto'])) {
    header("Location: afegirContingutForm.php?error=2");
    die();
}

// Si tras las comprobaciones todo es correcto, se añade el contenido a la base de datos
$query = "INSERT INTO contingut (titol, link, camiFoto, nomCat, visible) values ('$titulo','$html','$camiFoto','$nomCat', '1')"; //INSERTANDO VARIABLES DIRECTAMENTE
mysqli_query($con, $query);

// Se añade la relacion entre contenido y tipo
if(is_array($tipoCont)){
    foreach ($tipoCont as $valor) {
        $query = 'SELECT IdTipus FROM tipus WHERE edat="' . $valor . '"';
        $result = mysqli_query($con, $query);
        $idTipo = mysqli_fetch_array($result);
        $query = 'SELECT IdContingut FROM contingut WHERE titol="' . $titulo . '"';
        $result = mysqli_query($con, $query);
        $idContingt = mysqli_fetch_array($result);
        $query = "INSERT INTO r_tipus_contingut (IdTipus, IdContingut) values ('".$idTipo['IdTipus']."','".$idContingt['IdContingut']."')"; //INSERTANDO VARIABLES DIRECTAMENTE
        mysqli_query($con, $query);
    }
}

// Redirigimos al usuario a la página principal
header("Location: llistarContinguts.php?msg=3"); 
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