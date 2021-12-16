<div class="col-12">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-2 border-bottom border-danger">
        <div class="container-fluid">
            <button class="navbar-toggler" data-target="#menu"  data-toggle="collapse" type="button">
                <span class="navbar-toggler-icon"></span> <!-- Desplegable per a dispositius petits -->
            </button>

            <!-- LOGO -->
            <div class="mx-auto">
                <a href="login.php" class="navbar-brand">
                    <img src="img/logo.png" width="130" height="40">
                </a>
            </div>    
            

            <!-- Menú d'opcions -->
            <div class="collapse navbar-collapse" id="menu">   
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link active" href="login.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="llistarContinguts.php">Explorar</a></li>
                    <li class="nav-item dropdown"> <!-- Favorits -->
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Categorias  
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <?php
                            include "connection.php";
                            echo '<a class="dropdown-item" href="llistarCategories.php">Todas las categorias</a>';
                            $query = "SELECT * from categoria ORDER BY nomCat ASC";
                            $result = mysqli_query($con,$query);
                            while($row = mysqli_fetch_array($result)){  
                                echo '<a class="dropdown-item" href="llistaContingutCat.php?id='.$row['nomCat'].'">'.$row['nomCat'].'</a>';
                            }
                        ?>
                        </div>
                    </li>
                    <li class="nav-item dropdown"> <!-- Favorits -->
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Favoritos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="llistaContingutFavorit.php">Contenidos</a>
                            <a class="dropdown-item" href="llistaCategoriaFavorit.php">Categorias</a>
                        </div>
                    </li>
                    <?php // Si és administrador, afegim les opcions
                        if($_SESSION['administrador']==true){
                            echo '  <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Administrador
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            <a class="dropdown-item" href="afegirContingutForm.php">Añadir contenido</a>
                                            <a class="dropdown-item" href="editarContingutForm.php">Editar/Borrar contenido</a>
                                            <a class="dropdown-item" href="afegirCategoriaForm.php">Añadir categoria</a>
                                            <a class="dropdown-item" href="editarCategoriaForm.php">Editar/Borrar categoria</a>
                                            <a class="dropdown-item" href="visualitzarUsuarisForm.php">Visualizar usuarios</a>
                                        </div>
                                    </li>';
                            }
                        ?>
                </ul> 
                <div class="col"></div>
                <ul class="nav navbar-nav mx-auto">       
                <!-- Perfil i tancar sessió -->
                <div class="col-3-md">
                    <form class="form-inline" action="cercaContingut.php" method="post">
                        <div class="input-group mb-0">
                                    <input class="form-control mr-sm-1" name="cercador" type="search" placeholder="Buscar contenido..." aria-label="Search"&nbsp;
                                    <?php if(isset($_GET['cercador'])) echo 'value="'.$_GET['cercador'].'"'; ?>>
                                    <button class="btn btn-danger" type="submit">Buscar</button>
                        </div>
                        </form>
                    </div>
                    &nbsp;
                
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Perfil
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <!--<a class="dropdown-item" href="veureContracteActual.php">Ver contrato</a>-->
                            <a class="dropdown-item" href="veureUsuariForm.php">Mi perfil</a>
                            <a class="dropdown-item" href="#">Mensajes</a>
                            <?php
                                //si l'usuari no té cap contracte, l'opció que surt es la de
                                //contractar, fer un nou contracte
                                //en cas contrari, opció de veure el contracte
                                if($_SESSION['IdContracte'] == null){
                                    echo '<a class="dropdown-item" href="editarContracteForm.php">Contratar</a>';
                                }else{
                                    echo '<a class="dropdown-item" href="veureContracteActual.php">Ver contrato</a>';
                                }
                            ?>
                            <a class="dropdown-item" href="veureFactures.php">Facturas</a>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>
                </ul>
                

            </div>
        </div>
    </div>
</nav>
