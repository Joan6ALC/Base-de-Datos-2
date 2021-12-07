<div class="col-12">
    <nav class="navbar navbar-expand-md ml-auto navbar-light border-2 border-bottom border-danger" style="background-color: #FFFFFF;">
        <div class="container-fluid">

            <!-- LOGO -->
            <div class="mx-auto order-0">
                <a href="#" class="navbar-brand">
                    <img src="img/navbar_logo.png" width="130" height="40">
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#MenuNavegacion">
                    <span class="navbar-toggler-icon"></span> <!-- Desplegable per a dispositius petits -->
                </button>
            </div>

            <!-- Menú d'opcions -->
            <div class="collapse navbar-collapse" id="navbarNavDropdown">   
                <div id="MenuNavegacion" class="collapse navbar-collapse">
                    <ul class="navbar-nav mr-auto"> <!-- Alinear a la esquerra -->
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
                                                <a class="dropdown-item" href="#">Añadir contenidos</a>
                                                <a class="dropdown-item" href="#">Editar contenidos</a>
                                                <a class="dropdown-item" href="#">Añadir categoria</a>
                                                <a class="dropdown-item" href="#">Editar categoria</a>
                                                <a class="dropdown-item" href="#">Visualizar usuarios</a>
                                            </div>
                                        </li>';
                            }
                        ?>
                    </ul>              
                </div>
                                
                <!-- Perfil i tancar sessió -->
                <ul class="navbar-nav ml-auto"> <!-- Alinear la dreta-->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Mi perfil
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="veureContracteActual.php">Ver contrato</a>
                            <a class="dropdown-item" href="editarUsuariForm.php">Editar perfil</a>
                            <a class="dropdown-item" href="#">Mensajes</a>
                            <a class="dropdown-item" href="#">Facturas</a>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>