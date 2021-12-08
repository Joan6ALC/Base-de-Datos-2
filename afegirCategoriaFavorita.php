<!DOCTYPE html>
<body>

    <section>       
        
                                
    <header>
        <?php include "navbar.php"; ?>
    </header>
<?php 
    
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: index.html");
        die();
    }

    include "connection.php";
    $Categoria = $_GET['id'];

    echo "Aun no ha entrado";
    if(isset($_SESSION['IdContracte'])){
        echo "Ha entrado";
    $consulta = "SELECT nomCat FROM CategoriaFavorits WHERE IdContracte = ".$_SESSION['IdContracte']." AND nomCat = ".$Categoria."";
    $Resultado = mysqli_query($con, $consulta);
    if($Resultado){
        die();
    }else{
    $insert = "INSERT into CategoriaFavorits set";
    $insert = $insert."IdContracte='".$_SESSION['IdContracte']."',";
    $insert = $insert."nomCat='".$Categoria."'";
    mysqli_query($con, $insert);
    }
    die();  

    
?>
</section>
</body>
</html>