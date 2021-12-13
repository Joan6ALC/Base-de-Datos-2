function confirmDelete() {
    var resultado = window.confirm('¿Seguro que quieres borrar el contenido seleccionado?');
    if (resultado === true) {
        return true;
    } else { 
        return false;
        
    }
}

