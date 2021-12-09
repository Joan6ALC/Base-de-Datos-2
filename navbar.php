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
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="login.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="llistarContinguts.php">Explorar</a></li>
                    <li class="nav-item"><a class="nav-link" href="llistarCategories.php">Categorías</a></li>
                    <li class="nav-item dropdown"> <!-- Favorits -->
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Favoritos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">Contenidos</a>
                            <a class="dropdown-item" href="#">Categorias</a>
                        </div>
                    </li>
                    <?php // Si és administrador, afegim les opcions
                        if($_SESSION['administrador']==true){
                            echo '  <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Administrador
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            <a class="dropdown-item" href="#">Añadir contenido</a>
                                            <a class="dropdown-item" href="#">Editar/Borrar contenido</a>
                                            <a class="dropdown-item" href="#">Añadir categoria</a>
                                            <a class="dropdown-item" href="#">Editar/Borrar categoria</a>
                                            <a class="dropdown-item" href="#">Visualizar usuarios</a>
                                        </div>
                                    </li>';
                            }
                        ?>
                </ul>  
                                
                <!-- Perfil i tancar sessió -->
                <ul class="nav navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <li class="nav-item"><a class="nav-link" href="#"><img src="img/envelope.svg" height="25" width="25"></a></li>
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Mi perfil
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <?php
                                if($_SESSION['IdContracte'] == null){
                                    echo '<a class="dropdown-item" href="editarContracteForm.php">Hacer contrato</a>';
                                }else{
                                    echo '<a class="dropdown-item" href="veureContracteActual.php">Ver contrato</a>';
                                }
                            ?>
                            <!--<a class="dropdown-item" href="veureContracteActual.php">Ver contrato</a>-->
                            <a class="dropdown-item" href="veureUsuariForm.php">Ver perfil</a>
                            <a class="dropdown-item" href="editarUsuariForm.php">Editar perfil</a>
                            <a class="dropdown-item" href="veureFactures.php">Facturas</a>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>