const dropArea = document.querySelector(".dragArea"),
  dragText = dropArea.querySelector("header"),
  input = dropArea.querySelector("input");
let file; // Variables globales para usar dentro de las diferentes funciones

input.addEventListener("change", function () {
  // Tomamos el fichero seleccionado por el usuario y [0] por loque si el usurio introduce varios, tomamos el primero
  file = this.files[0];
  dropArea.classList.add("active");
  showFile(); // Llamada a la función
});
// Si el usuario sube un archivo deslizando
dropArea.addEventListener("dragover", (event) => {
  dropArea.classList.add("active");
});
// Si se encuentra sobre el dragBox
dropArea.addEventListener("dragleave", () => {
  dragText.innerHTML = 'Suelta para subir el archivo <span style="color: red;">*</span>';
});
// Sisuelta el archivo en el dragBox
dropArea.addEventListener("drop", (event) => {
  // Tomamos el fichero seleccionado por el usuario y [0] por loque si el usurio introduce varios, tomamos el primero
  file = event.dataTransfer.files[0];
  showFile(); // Llamamos a la función
});
function showFile() {
  dragText.innerHTML = 'Archivo subido con éxito <i class="bi bi-check-lg" style="color: green;"></i>';
  let fileType = file.type; // Tomamos el archivo seleccionado
  let validExtensions = ["image/jpeg", "image/png"]; // Extensiones aceptadas
  if (!validExtensions.includes(fileType)) {
    const div = document.querySelector(".alerta"); 
    div.innerHTML = '<div class="padding"></div><div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="bi-file-earmark-excel" style="font-size: 0.9rem;"></i>  El archivo insertado no es una imagen!</div>'; // Interpreta el HTML
    dropArea.classList.remove("active");
    input.value = '';
    dragText.innerHTML = 'Arrastra o selecciona el archivo para subirlo <span style="color: red;">*</span>';
  }
}
