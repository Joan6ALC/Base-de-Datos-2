<?php
$con = mysqli_connect("localhost","root","") or die("Localhost no disponible");
$db = mysqli_select_db($con,"pelistube") or die("Base de datos no disponible");
//$con -> set_charset("utf8");
?>