<?php
include("conexion.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST["usuario"];
    $pass = $_POST["pass"];



//Login 
//como el login y el registro dependen de la misma hoja, lo que les va permitir diferencia es el nombre del boton
if (isset($_POST["inicio"])) //CHECAR tmb pq es el value, no name
{
    $query = mysqli_query($conn, "SELECT `correo`, `contraseña` FROM `cliente` WHERE `correo`= '$nombre' AND `contraseña` = '$pass'");
    $nr = mysqli_num_rows($query);

    if ($nombre == "Admin" || $pass == "Admin1234") {
        $_SESSION['iniciada'] = "si";
        echo "<script> alert('Bienvenido $nombre'); window.location='Admin.php' </script>";
    }

    if ($nr == 1) //variable que cuente las filas, si la respuesta es 1 lo va deja avanzar
    {
        $sqlgrabar = "SELECT * FROM `cliente` WHERE `correo` = '$nombre'";
        $resultado = $conn->query($sqlgrabar);
        $datosCliente = $resultado->fetch_assoc();
        $resultado->free();
        
        $_SESSION['codigoCliente'] = $datosCliente["codigoCliente"];
        $_SESSION['correo'] = $datosCliente["correo"];
        $_SESSION['contraseña'] = $datosCliente["contraseña"];
        $_SESSION['nom1'] = $datosCliente["primerNombre"];
        $_SESSION['nom2'] = $datosCliente["segundoNombre"];
        $_SESSION['app'] = $datosCliente["apellidoPaterno"];
        $_SESSION['apm'] = $datosCliente["apellidoMaterno"];
        $_SESSION['fechaNac'] = $datosCliente["fechaNacimiento"];
        $_SESSION['paisOrigen'] = $datosCliente["paisOrigen"];
        $_SESSION['genero'] = $datosCliente["genero"];
        
        $_SESSION['iniciada'] = "si";
        echo "<script> alert('Bienvenido $nombre'); window.location='Index.html' </script>";
    } else {
        echo "<script> alert('Usuario no existe'); window.location='FormularioInicio.html' </script>";
    }
}

//Registrarse 
if (isset($_POST["registro"])) //falta crear boton
{
    //$sqlgrabar = "INSERT INTO login(usuario, password) values ('$nombre', '$pass')"; //se crea query para insertar datos
    $sqlgrabar = "INSERT INTO `cliente` (`codigoCliente`, `correo`, `contraseña`, `primerNombre`, `segundoNombre`, `apellidoPaterno`,
        `apellidoMaterno`, `fechaNacimiento`, `paisOrigen`, `genero`) VALUES 
        (NULL, '$nombre', '$pass', NULL, NULL, NULL, NULL, NULL, NULL, NULL)";

    if (mysqli_query($conn, $sqlgrabar)) {
        echo "<script> alert('Usuario registrado con exito: $nombre'); window.location='FormularioInicio.html' </script>";
        //include "Registrarse.html";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

    // Resto del código de tu script PHP para el manejo de datos...
}

?>