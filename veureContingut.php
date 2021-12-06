<?php
    include "connection.php";
    $query = "select * from contingut where IdContingut=".$_GET['id'] ; 
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_array($result);
    echo $row['html'];
?>