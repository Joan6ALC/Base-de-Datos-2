const dropArea = document.querySelector(".dragArea"),
  dragText = dropArea.querySelector("header"),
  input = dropArea.querySelector("input");
let file; //this is a global variable and we'll use it inside multiple functions

input.addEventListener("change", function () {
  //getting user select file and [0] this means if user select multiple files then we'll select only the first one
  file = this.files[0];
  dropArea.classList.add("active");
  showFile(); //calling function
});
//If user Drag File Over DropArea
dropArea.addEventListener("dragover", (event) => {
  dropArea.classList.add("active");
});
//If user leave dragged File from DropArea
dropArea.addEventListener("dragleave", () => {
  dragText.innerHTML = 'Suelta para subir el archivo <span style="color: red;">*</span>';
});
//If user drop File on DropArea
dropArea.addEventListener("drop", (event) => {
  //getting user select file and [0] this means if user select multiple files then we'll select only the first one
  file = event.dataTransfer.files[0];
  showFile(); //calling function
});
function showFile() {
  dragText.innerHTML = 'Archivo subido con éxito <i class="bi bi-check-lg" style="color: green;"></i>';
  let fileType = file.type; //getting selected file type
  let validExtensions = ["image/jpeg", "image/png"]; //adding some valid image extensions in array
  if (!validExtensions.includes(fileType)) {
    const div = document.querySelector(".alerta"); // <div class="info"></div>
    div.innerHTML = '<div class="padding"></div><div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="bi-file-earmark-excel" style="font-size: 0.9rem;"></i>  El archivo insertado no es una imagen!</div>'; // Interpreta el HTML
    dropArea.classList.remove("active");
    input.value = '';
    dragText.innerHTML = 'Arrastra o selecciona el archivo para subirlo <span style="color: red;">*</span>';
  }
}
