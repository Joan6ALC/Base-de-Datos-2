
<?php 
    
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: index.html");
        die();
    }

    include "connection.php";
    $Categoria = $_GET['id'];

    if(isset($_SESSION['IdContracte'])){

    $consulta = "SELECT nomCat FROM CategoriaFavorits WHERE IdContracte = ".$_SESSION['IdContracte']." AND nomCat = ".$Categoria."";
    $Resultado = mysqli_query($con, $consulta);
    if(isset($Resultado)){
        $insert = "INSERT into CategoriaFavorits (IdContracte, nomCat) VALUES ('".$_SESSION['IdContracte']."','".$Categoria."')";
        mysqli_query($con, $insert);

    }
}
header("Location: llistarCategories.php");
die();

    
?>