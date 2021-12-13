function confirmDelete() {
    var resultado = window.confirm('¿Seguro que quieres borrar el contenido seleccionado?');
    if (resultado === true) {
        return true;
    } else { 
        return false;
        
    }
}

function ns(){
    const selectElement = document.querySelector('.facturas');

                                                    selectElement.addEventListener('change', (event) => {
                                                    const result = document.querySelector('.result');
                                                    result.textContent = 'You like ${event.target.value}';
                                                    });
}
