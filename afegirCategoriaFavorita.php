
<?php 
    
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: index.html");
        die();
    }

    include "connection.php";
    $Categoria = $_GET['id'];
    $redirect = $_GET['redir'];

    if(isset($_SESSION['IdContracte'])){
    $insert = "INSERT into CategoriaFavorits (IdContracte, nomCat) VALUES ('".$_SESSION['IdContracte']."','".$Categoria."')";
    mysqli_query($con, $insert);
    
}
mysqli_close($con);
header("Location: llistarCategories.php");
die();
  
?>