<?php 
if (isset($_SESSION["connecte"]))
$connecte=$_SESSION["connecte"];
else 
$connecte=false;



if (!$connecte){
    include('acceuil/NC.php');
}
else {
    if (isset($_SESSION["role"]))
    $role=$_SESSION["role"];
    if($role='coach'){
        include('acceuil/Coach.php');
    } else {
        include('acceuil/Athlete.php');
    }
}
?>
