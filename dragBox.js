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
  dragText.textContent = "Release to Upload File";
});
//If user drop File on DropArea
dropArea.addEventListener("drop", (event) => {
  //getting user select file and [0] this means if user select multiple files then we'll select only the first one
  file = event.dataTransfer.files[0];
  showFile(); //calling function
});
function showFile() {
  dragText.textContent = "uploaded";
  let fileType = file.type; //getting selected file type
  let validExtensions = ["image/jpeg", "image/png"]; //adding some valid image extensions in array
  if (!validExtensions.includes(fileType)) {
    //if user selected file is an image file
    alert("El archivo insertado no es una imagen!");
    dropArea.classList.remove("active");
  }
}
