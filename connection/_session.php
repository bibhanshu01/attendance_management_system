<?php
session_start(); 

// if (!isset($_SESSION['userId']))
// {
//   echo "<script type = \"text/javascript\">
//   window.location = (\"../index.php\");
//   </script>";

// }

if(!isset($_SESSION['loggedin']) || ($_SESSION['loggedin']!=true)){
    header("location: ../index.php");
   
}





?>