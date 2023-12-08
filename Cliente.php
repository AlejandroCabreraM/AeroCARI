<?php
include("conexion.php");
session_start();

$nombre = $_SESSION['correo'] = $_POST['usuario'];
$nom1 = $_SESSION['nom1'] = $_POST['nomb1'];

if ($_POST['nomb2'] == "") {
    $nom2 = $_SESSION['nom2'] = $_POST['nomb2'] = NULL;
} else if ($_POST['nomb2'] != NULL || $_POST['nomb2'] != "") {
    $nom2 = $_SESSION['nom2'] = $_POST['nomb2'];
}

$apP = $_SESSION['app'] = $_POST['apPat'];
$apM = $_SESSION['apm'] = $_POST['apMat'];
$date = $_SESSION['fechaNac'] = $_POST['fechaNac'];
if ($_POST['pais'] == "") {
    $pais = $_SESSION['paisOrigen'] = $_POST['pais'] = NULL;
} else if ($_POST['pais'] != NULL || $_POST['pais'] != "") {
    $pais = $_SESSION['paisOrigen'] = $_POST['pais'];
}
$gen = $_SESSION['genero'] = $_POST['Genero'];
$tel = $_SESSION['tel'] = $_POST['telefono'];

if (isset($_POST['submit'])) {
    // El formulario se ha enviado, ejecutar el código
    if (isset($_SESSION['iniciada']) && $_SESSION['iniciada'] === 'si') {
        $codigoCliente = $_SESSION['codigoCliente'];

        // Verificar si el cliente ya tiene un teléfono registrado
        $sqlVerificarTelefono = "SELECT * FROM `clientetelefono` WHERE `codigoCliente` = '$codigoCliente'";
        $resultadoVerificarTelefono = $conn->query($sqlVerificarTelefono);

        $sqlInsertarCliente = "UPDATE `cliente` SET `correo`='$nombre',
                                                    `primerNombre`='$nom1',
                                                    `segundoNombre`='$nom2',
                                                    `apellidoPaterno`='$apP',
                                                    `apellidoMaterno`='$apM',
                                                    `fechaNacimiento`='$date',
                                                    `paisOrigen`='$pais',
                                                    `genero`='$gen' WHERE `codigoCliente`='$codigoCliente'";

            // if (mysqli_query($conn, $sqlInsertarCliente)) {
            //     echo "<script> alert('Se guardó los datos del cliente: $nombre'); window.location='AvionDibujo.php' </script>";
            // } else {
            //     echo "Error: " . $sqlInsertarCliente . "<br>" . mysqli_error($conn);
            // }

        if ($resultadoVerificarTelefono->num_rows > 0) {
            // El cliente ya tiene un teléfono registrado, actualiza el teléfono
            $sqlActualizarTelefono = "UPDATE `clientetelefono` SET `telefono`='$tel' WHERE `codigoCliente`='$codigoCliente'";

            if (mysqli_query($conn, $sqlActualizarTelefono) && mysqli_query($conn, $sqlInsertarCliente)) {
                echo "<script> alert('Se actualizó el teléfono del cliente: $nombre '); window.location='AvionDibujo.php' </script>";
            } else {
                echo "Error: " . $sqlActualizarTelefono . "<br>" . mysqli_error($conn);
            }
        } else {
            // El cliente no tiene teléfono registrado, inserta el nuevo teléfono
            $sqlInsertarTelefono = "INSERT INTO `clientetelefono` (`codigoCliente`, `telefono`) VALUES ('$codigoCliente', '$tel')";

            if (mysqli_query($conn, $sqlInsertarTelefono)) {
                echo "<script> alert('Se guardó el teléfono del cliente: $nombre'); window.location='AvionDibujo.php' </script>";
            } else {
                echo "Error: " . $sqlInsertarTelefono . "<br>" . mysqli_error($conn);
            }
        }
    } else if (!isset($_SESSION['iniciada']) || $_SESSION['iniciada'] === 'no') {
        // Obtener el menor códigoCliente no utilizado
        $queryCodigoCliente = "SELECT MIN(t1.codigoCliente + 1) AS codigoCliente
                               FROM cliente t1
                               LEFT JOIN cliente t2 ON t1.codigoCliente + 1 = t2.codigoCliente
                               WHERE t2.codigoCliente IS NULL";

        $resultCodigoCliente = mysqli_query($conn, $queryCodigoCliente);

        if ($resultCodigoCliente) {
            $rowCodigoCliente = mysqli_fetch_assoc($resultCodigoCliente);
            $codigoCliente = $rowCodigoCliente['codigoCliente'];

            // Insertar el nuevo cliente con el códigoCliente obtenido
            $sqlInsertarCliente = "INSERT INTO `cliente` (`codigoCliente`, `correo`, `primerNombre`, `segundoNombre`, `apellidoPaterno`,
            `apellidoMaterno`, `fechaNacimiento`, `paisOrigen`, `genero`) VALUES 
            ('$codigoCliente', '$nombre', '$nom1', '$nom2', '$apP', '$apM', '$date', '$pais', '$gen')";

            if (mysqli_query($conn, $sqlInsertarCliente)) {
                echo "<script> alert('Se guardó los datos del cliente: $nombre'); window.location='AvionDibujo.php' </script>";
            } else {
                echo "Error: " . $sqlInsertarCliente . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Error: " . $queryCodigoCliente . "<br>" . mysqli_error($conn);
        }
    }
}
?>