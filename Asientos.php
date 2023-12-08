<?php
include("conexion.php");

//VUELO
$costo = 1095;
$origen = $_SESSION['origen'];
$destino = $_SESSION['destino'];
$diaV = $_POST["diaViaje"];
$total = $_POST["total"];

//ASIENTO
$nAsientos = $_POST["nSeats"]; //numero del asiento CHECAR, numero de asiento meh
$costoAsientos = $_POST["seleccionAsiento"];


/*$sqlgrabar = "INSERT INTO `vuelo`(`numVuelo`, `costoVuelo`, `origen`, `destino`, `TUA`, `fechaVuelo`) VALUES 
    (NULL, '', '$origen', '$destino', '', '$diaV')";

    if (mysqli_query($conn, $sqlgrabar)) {
        //echo "<script> alert('Se guardó los datos del cliente: $nombre'); </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }*/


$sqlgrabar2 = "SELECT numVuelo FROM vuelo WHERE origen = '$origen' AND destino = '$destino'";
$resultado = $conn->query($sqlgrabar2);
$datosVuelo = $resultado->fetch_assoc();
$resultado->free();
$idVuelo = $datosVuelo["numVuelo"];

$sqlgrabar = "INSERT INTO `asiento`(`idAsiento`, `numeroAsiento`, `numVuelo`, `costoAsiento`) 
        VALUES (NULL,'$nAsientos', '$idVuelo' ,'$costoAsientos')";

if (mysqli_query($conn, $sqlgrabar)) {
    echo "<script> alert('Asientos correctamente seleccionados'); window.location='AvionDibujo.html' </script>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
