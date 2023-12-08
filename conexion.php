<?php
    $dbhost = "localhost"; //host donde esta la base de datos
    $dbname = "avion"; //nombre de BD ES AEROPUERTO O AVION
    $dbuser = "root"; // user name
    $dbpass = ""; // password de usuario
    // session_start();
    // $_SESSION['iniciada'] = "no";

    //SE HACE UNA CONEXION
    $conn= mysqli_connect($dbhost, $dbuser, $dbpass, $dbname,"3307");

    if(!$conn){
        die("No hay conexion: ".mysqli_connect_error());
    }
?>