<?php
include("conexion.php");
    session_start(); // Iniciar o reanudar una sesión
    $_SESSION = array();// Destruir todas las variables de sesión
    
    session_destroy(); //destruir sesion

    echo "<script>alert('Se ha cerrado la sesión con éxito'); window.location='FormularioInicio.html';</script>";
    //echo "<script> alert('Se ha cerrado sesion con éxito');</script>";
    //header("location:FormularioInicio.html"); // redireccionar

    exit;
?>