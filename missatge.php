<?php
if(isset($_GET['msg'])){
    echo '<div class="padding"></div>';
    switch($_GET['msg']){
        case 1: // Eliminació contingut
            echo    '</div><div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi-trash" style="font-size: 0.9rem;"></i>
                        &nbspContenido eliminado correctamente
                        <button type="button" style="background-color: transparent; border: 0px;" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            break;
        
        case 2: // Edició contingut
            echo    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi-check2-square" style="font-size: 0.9rem;"></i>
                        &nbspContenido editado correctamente
                        <button type="button" style="background-color: transparent; border: 0px; class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            break;

        case 3: // Addició contingut
            echo    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <i class="bi-plus-circle" style="font-size: 0.9rem;"></i>
                        &nbspContenido añadido correctamente
                        <button type="button" style="background-color: transparent; border: 0px; class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            break;
    
        case 4: // Edició categoria
            echo    '<div class="alert alert-sucess alert-dismissible fade show" role="alert">
                        <i class="bi-check2-square" style="font-size: 0.9rem;"></i>
                        &nbspCategoría editada correctamente
                        <button type="button" style="background-color: transparent; border: 0px;" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            break;

        case 5: // Addició categoria
            echo    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <i class="bi-tags" style="font-size: 0.9rem;"></i>
                        &nbspCategoría añadida correctamente
                        <button type="button" style="background-color: transparent; border: 0px;" class="close" data-dismiss="alert" aria-label="close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                break;
                
        case 6: // Eliminació categoria favorita
            echo    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi-star" style="font-size: 0.9rem;"></i>
                        &nbspCategoría favorita eliminada correctamente
                        <button type="button" style="background-color: transparent; border: 0px;" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            break;
        
        case 7: // Addició categoria favorita
            echo    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi-star" style="font-size: 0.9rem;"></i>
                        &nbspCategoria favorita añadida correctamente
                        <button type="button" style="background-color: transparent; border: 0px;" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            break;
            
        case 8: // Addició contingut favorit
            echo    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi-star" style="font-size: 0.9rem;"></i>
                        &nbspContenido favorito añadido correctamente
                        <button type="button" style="background-color: transparent; border: 0px; class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            break;

        case 9: // Eliminació contingut favorita
            echo    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi-star" style="font-size: 0.9rem;"></i>
                        &nbspContenido favorito eliminado correctamente
                        <button type="button" style="background-color: transparent; border: 0px; class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            break;
        
        default: 
    }
}
?>