<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    die();
}
// Connexió a bd
include "connection.php";

//Guardam els valors passats per paràmetre
$cat = $_POST['catSelect'];
$visible = $_POST['visible'];

//Assignam la variable 'visible'
if (isset($visible) && $visible == '1')
        $visible = 1;
    else
        $visible = 0;

//Cercam la categoria corresponent        
$query = 'SELECT * FROM categoria WHERE nomCat="' . $cat . '"';
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);

//Actualitzam les dades de la categoria
$query = 'UPDATE categoria SET visible="'. $visible .'"  WHERE (nomCat="' . $cat . '")';
mysqli_query($con, $query);

header("Location: editarCategoriaForm.php?msg=4"); // Redirigim a l'usuari al formulari d'edició de categoria
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
        <?php 
        include "navbar.php"; 
        include "missatge.php";
        ?>
    </header>
    <!-- Frameworks -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>