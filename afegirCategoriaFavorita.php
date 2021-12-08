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
    $consulta = "SELECT nomCat FROM CategoriaFavorits WHERE idContracte = '".$_SESSION['IdContracte']."'";
    $Resultado = mysqli_query($con, $consulta);

    while($Registre = mysqli_fetch_array($Resultado)){
        if($Categoria==$Registre['nomCat']){
            echo "La categoria ya estaba dentro";
            
        }
    }
    $insert = "INSERT into CategoriaFavorits set";
    $insert = $insert."IdContracte='".$_SESSION['IdContracte']."',";
    $insert = $insert."nomCat='".$Categoria."'";
    mysqli_query($con, $insert);
    echo "Se ha añadido la categoria a favoritos";
    
    }else{
        echo "Sesion no iniciada";
        
    }

    
?>
</section>
</body>
</html>